<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class WalletController extends Controller
{
    protected $web3;

    public function __construct()
    {
        // Inisialisasi Web3 dengan URL Infura/Alchemy
        $infuraUrl = env("INFURA_URL", "https://sepolia.infura.io/v3/eb6657f1f2664ba890d5eee99b17103b");
        $this->web3 = new Web3(new HttpProvider(new HttpRequestManager($infuraUrl, 10)));
    }

    /**
     * Ambil alamat wallet pengguna
     */
    public function getWalletAddress(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                Log::error('Pengguna tidak terautentikasi saat mengambil wallet address');
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak terautentikasi'
                ], 401);
            }

            $walletAddress = $user->wallet_address;
            Log::info('Mengambil alamat wallet untuk pengguna ID: ' . $user->id . ', wallet_address: ' . ($walletAddress ?? 'null'));

            return response()->json([
                'success' => true,
                'wallet_address' => $walletAddress
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil alamat wallet: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil alamat wallet: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Simpan alamat wallet
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'wallet_address' => 'required|string|size:42|regex:/^0x[a-fA-F0-9]{40}$/'
            ]);

            $walletAddress = $request->input('wallet_address');
            Log::info('Menyimpan alamat wallet: ' . $walletAddress . ' untuk pengguna ID: ' . Auth::id());

            // Simpan alamat wallet ke database
            $user = Auth::user();
            if (!$user) {
                Log::error('Pengguna tidak terautentikasi saat menyimpan wallet');
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak terautentikasi'
                ], 401);
            }

            // Verifikasi bahwa $user adalah instance Eloquent Model
            if (!$user instanceof Model) {
                Log::error('Objek pengguna bukan instance Eloquent Model', [
                    'user_class' => get_class($user)
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Kesalahan server: Objek pengguna tidak valid'
                ], 500);
            }

            // Log tipe user untuk debugging
            Log::info('Tipe objek pengguna: ' . get_class($user));

            // Cek apakah wallet_address sudah ada di database
            $existingUser = User::where('wallet_address', $walletAddress)->first();
            if ($existingUser && $existingUser->id !== $user->id) {
                Log::warning('Alamat wallet sudah digunakan oleh pengguna lain: ' . $walletAddress);
                return response()->json([
                    'success' => false,
                    'message' => 'Alamat wallet sudah terkait dengan akun lain'
                ], 422);
            }

            // Update wallet_address menggunakan fill dan save
            $user->fill(['wallet_address' => $walletAddress])->save();
            Log::info('Alamat wallet berhasil disimpan untuk pengguna ID: ' . $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Alamat wallet berhasil disimpan'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal saat menyimpan wallet: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . json_encode($e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan alamat wallet: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan alamat wallet: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verifikasi alamat dompet dan ambil saldo
     */
    public function verifyWallet(Request $request)
    {
        $request->validate([
            "address" => "required|string|size:42|regex:/^0x[a-fA-F0-9]{40}$/",
        ]);

        $address = $request->input("address");
        Log::info('Memverifikasi alamat wallet: ' . $address);

        try {
            // Ambil saldo dalam Wei
            $eth = $this->web3->eth;
            $balanceInWei = null;
            $callbackExecuted = false;

            $eth->getBalance($address, function ($err, $balance) use (&$balanceInWei, &$callbackExecuted) {
                $callbackExecuted = true;
                if ($err !== null) {
                    Log::error('Gagal mengambil saldo dari Infura: ' . $err->getMessage());
                    throw new \Exception("Gagal mengambil saldo: " . $err->getMessage());
                }
                $balanceInWei = (string) $balance;
                Log::info('Saldo berhasil diambil: ' . $balanceInWei . ' Wei');
            });

            // Tunggu callback selesai (timeout 10 detik)
            $startTime = time();
            while (!$callbackExecuted && (time() - $startTime) < 10) {
                usleep(100000); // Tunggu 100ms
            }

            if (!$callbackExecuted) {
                Log::error('Timeout menunggu respons dari Infura untuk alamat: ' . $address);
                throw new \Exception("Gagal mengambil saldo: Timeout menunggu respons dari Infura");
            }

            if ($balanceInWei === null) {
                Log::error('Data saldo tidak tersedia untuk alamat: ' . $address);
                throw new \Exception("Gagal mengambil saldo: Tidak ada data saldo");
            }

            // Konversi Wei ke ETH
            $balanceInEth = bcdiv($balanceInWei, "1000000000000000000", 18);
            Log::info('Saldo dalam ETH: ' . $balanceInEth . ' untuk alamat: ' . $address);

            // Jika saldo nol, tetap lanjutkan
            if ($balanceInEth == 0) {
                Log::warning('Saldo nol untuk alamat: ' . $address);
            }

            // Ambil harga ETH dalam IDR dari CoinGecko dengan retry
            $ethPriceInIdr = null;
            $maxRetries = 3;
            $retryCount = 0;

            while ($retryCount < $maxRetries && $ethPriceInIdr === null) {
                try {
                    $response = Http::timeout(10)->get("https://api.coingecko.com/api/v3/simple/price", [
                        "ids" => "ethereum",
                        "vs_currencies" => "idr",
                    ]);

                    if ($response->successful()) {
                        $ethPriceInIdr = $response->json()["ethereum"]["idr"] ?? null;
                        if ($ethPriceInIdr === null) {
                            throw new \Exception("Harga ETH dalam IDR tidak tersedia dari CoinGecko");
                        }
                        Log::info('Harga ETH dalam IDR: ' . $ethPriceInIdr);
                    } else {
                        throw new \Exception("Gagal mengambil harga ETH dari CoinGecko: " . $response->reason());
                    }
                } catch (\Exception $e) {
                    $retryCount++;
                    Log::warning("Gagal mengambil harga ETH (percobaan $retryCount/$maxRetries): " . $e->getMessage());
                    if ($retryCount === $maxRetries) {
                        // Fallback ke harga statis jika semua percobaan gagal
                        $ethPriceInIdr = env('FALLBACK_ETH_PRICE_IDR', 35000000);
                        Log::warning('Menggunakan harga ETH fallback: ' . $ethPriceInIdr);
                    } else {
                        sleep(2);
                    }
                }
            }

            if ($ethPriceInIdr === null) {
                throw new \Exception("Gagal mengambil harga ETH setelah $maxRetries percobaan");
            }

            $balanceInIdr = bcmul($balanceInEth, (string) $ethPriceInIdr, 2);

            return response()->json([
                "success" => true,
                "address" => $address,
                "balance_eth" => $balanceInEth . " ETH",
                "balance_idr" => $balanceInIdr,
            ]);
        } catch (\Exception $e) {
            Log::error("Error verifikasi dompet: " . $e->getMessage(), [
                'address' => $address,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                "success" => false,
                "error" => "Gagal verifikasi dompet: " . $e->getMessage()
            ], 500);
        }
    }
}
