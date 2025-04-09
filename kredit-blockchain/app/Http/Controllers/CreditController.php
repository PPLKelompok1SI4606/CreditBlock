<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditRequest;
use Web3\Web3;
use Web3\Contract;

class CreditController extends Controller
{
    public function requestCredit(Request $request)
    {
        $web3 = new Web3(env('ETHEREUM_NETWORK'));
        $contractAddress = 'YOUR_CONTRACT_ADDRESS';
        $abi = json_decode(file_get_contents(base_path('blockchain/artifacts/contracts/CreditSystem.sol/CreditSystem.json')), true)['abi'];

        $contract = new Contract($web3->provider, $abi);
        $contract->at($contractAddress)->call('requestCredit', [$request->amount], function ($err, $result) {
            if ($err) return response()->json(['error' => $err->getMessage()]);
        });

        CreditRequest::create([
            'user_address' => $request->user_address,
            'amount' => $request->amount,
        ]);

        return response()->json(['message' => 'Credit requested']);
    }
}
