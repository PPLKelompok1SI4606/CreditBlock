document.addEventListener("DOMContentLoaded", () => {
    const connectButton = document.getElementById("connect-metamask");
    const walletAddressElement = document.getElementById("wallet-address");
    const walletBalanceElement = document.getElementById("wallet-balance");
    const walletIndicator = document.getElementById("wallet-indicator");

    // Fungsi untuk format Rupiah
    const formatRupiah = (angka) => {
        return (
            "Rp " +
            parseFloat(angka)
                .toFixed(0)
                .replace(/\d(?=(\d{3})+$)/g, "$&.")
        );
    };

    // Cek apakah ethers.js tersedia
    if (typeof ethers === "undefined") {
        console.error("ethers.js tidak dimuat. Periksa CDN atau file lokal di public/js/ethers-5.7.2.umd.min.js.");
        alert("Gagal memuat library MetaMask. Silakan refresh halaman atau periksa koneksi internet.");
        connectButton.disabled = true;
        return;
    } else {
        console.log("ethers.js berhasil dimuat, versi:", ethers.version);
    }

    // Cek apakah MetaMask terinstall
    if (typeof window.ethereum === "undefined") {
        console.error("MetaMask tidak terdeteksi. Pastikan ekstensi MetaMask terinstall.");
        alert("MetaMask tidak terdeteksi. Silakan install MetaMask di browser Anda.");
        connectButton.disabled = true;
        return;
    }

    // Koneksi ke MetaMask
    connectButton.addEventListener("click", async () => {
        try {
            // Cek apakah MetaMask terkunci atau tidak responsif
            if (!window.ethereum.isConnected()) {
                throw new Error("MetaMask tidak responsif. Pastikan MetaMask tidak terkunci.");
            }

            // Minta akses akun menggunakan Web3Provider
            const provider = new ethers.providers.Web3Provider(window.ethereum);
            const accounts = await provider.send("eth_requestAccounts", []);
            const signer = provider.getSigner();
            const address = await signer.getAddress();

            // Update UI
            walletAddressElement.textContent = address.substring(0, 6) + "..." + address.substring(address.length - 4);
            walletIndicator.classList.remove("bg-red-400", "ring-red-200");
            walletIndicator.classList.add("bg-green-400", "ring-green-200");
            walletIndicator.title = "Dompet terkoneksi";
            console.log("Alamat wallet terkoneksi:", address);

            // Panggil backend untuk verifikasi dan ambil saldo dalam IDR
            const verifyResponse = await fetch("/api/wallet/verify", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ address }),
            });

            const verifyResult = await verifyResponse.json();
            console.log("Respons dari /api/wallet/verify:", verifyResult);

            if (!verifyResult.success) {
                const errorMessage = verifyResult.error || "Kesalahan tidak diketahui dari server";
                console.error("Verifikasi dompet gagal:", errorMessage);
                alert("Gagal verifikasi dompet: " + errorMessage);
                return;
            }

            // Tampilkan saldo dalam Rupiah, bahkan jika nol
            walletBalanceElement.textContent = formatRupiah(verifyResult.balance_idr || 0);
            console.log("Saldo ditampilkan: Rp", verifyResult.balance_idr || 0);

            // Simpan alamat wallet ke backend
            const storeResponse = await fetch("{{ route('wallet.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ wallet_address: address }),
            });

            // Cek apakah respons adalah JSON
            const contentType = storeResponse.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                const text = await storeResponse.text();
                console.error("Respons dari wallet.store bukan JSON:", text);
                alert("Gagal menyimpan alamat wallet: Server mengembalikan respons yang tidak valid");
                return;
            }

            const storeResult = await storeResponse.json();
            console.log("Respons dari wallet.store:", storeResult);
            if (!storeResult.success) {
                console.error("Gagal menyimpan alamat wallet:", storeResult.message);
                alert("Gagal menyimpan alamat wallet: " + (storeResult.message || "Kesalahan tidak diketahui"));
            } else {
                console.log("Wallet address saved:", address);
            }
        } catch (error) {
            console.error("Gagal koneksi ke MetaMask:", error.message, error);
            if (error.code === 4001) {
                alert("Koneksi ditolak oleh MetaMask. Silakan izinkan koneksi.");
            } else if (error.code === -32002) {
                alert("Permintaan MetaMask sedang menunggu. Cek popup MetaMask di browser Anda.");
            } else {
                alert("Gagal koneksi ke MetaMask: " + error.message);
            }
        }
    });

    // Tangani perubahan akun MetaMask
    window.ethereum?.on("accountsChanged", async (accounts) => {
        try {
            if (accounts.length > 0) {
                const provider = new ethers.providers.Web3Provider(window.ethereum);
                const address = accounts[0];

                // Update UI
                walletAddressElement.textContent = address.substring(0, 6) + "..." + address.substring(address.length - 4);
                walletIndicator.classList.remove("bg-red-400", "ring-red-200");
                walletIndicator.classList.add("bg-green-400", "ring-green-200");
                walletIndicator.title = "Dompet terkoneksi";
                console.log("Akun MetaMask berubah:", address);

                // Ambil saldo dari backend
                const response = await fetch("/api/wallet/verify", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ address }),
                });

                const result = await response.json();
                console.log("Respons dari /api/wallet/verify (accountsChanged):", result);
                if (result.success) {
                    walletBalanceElement.textContent = formatRupiah(result.balance_idr || 0);
                    console.log("Saldo diperbarui: Rp", result.balance_idr || 0);
                } else {
                    walletBalanceElement.textContent = "Rp 0";
                    const errorMessage = result.error || "Kesalahan tidak diketahui dari server";
                    console.error("Gagal verifikasi saldo:", errorMessage);
                }
            } else {
                walletAddressElement.textContent = "Belum terkoneksi";
                walletBalanceElement.textContent = "Rp 0";
                walletIndicator.classList.remove("bg-green-400", "ring-green-200");
                walletIndicator.classList.add("bg-red-400", "ring-red-200");
                walletIndicator.title = "Wallet belum terkoneksi";
                console.log("Tidak ada akun MetaMask terhubung");
            }
        } catch (error) {
            console.error("Gagal menangani perubahan akun:", error.message, error);
            alert("Gagal menangani perubahan akun MetaMask: " + error.message);
        }
    });
});
