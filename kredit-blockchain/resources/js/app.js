// import { ethers } from "ethers";

// const rupiahTokenAddress = "0xa7298AbA0e1C1160B8475Aa9876846debdb37441"; // Ganti dengan alamat dari deploy
// const creditSystemAddress = "0x5DDfDAB290906e26b3353C5c7b3F7480c0835aBF"; // Ganti dengan alamat dari deploy
// const tokenAbi = require('../../blockchain/artifacts/contracts/RupiahToken.sol/RupiahToken.json').abi;
// const creditAbi = require('../../blockchain/artifacts/contracts/CreditSystem.sol/CreditSystem.json').abi;

// async function connectMetaMask() {
//     if (window.ethereum) {
//         await window.ethereum.request({ method: "eth_requestAccounts" });
//         const provider = new ethers.BrowserProvider(window.ethereum);
//         return provider.getSigner();
//     }
//     throw new Error("MetaMask tidak terdeteksi!");
// }

// async function requestCredit(amount, duration) {
//     const signer = await connectMetaMask();
//     const creditContract = new ethers.Contract(creditSystemAddress, creditAbi, signer);

//     // Validasi di frontend
//     if (amount < 1000000) throw new Error("Jumlah minimal 1 juta IDR");
//     if (duration < 1 || duration > 60) throw new Error("Durasi harus antara 1-60 bulan");

//     const tx = await creditContract.requestLoan(ethers.utils.parseEther(amount.toString()), duration);
//     const receipt = await tx.wait();

//     // Ambil loanId dari event LoanRequested
//     const event = receipt.logs
//         .map(log => {
//             try {
//                 return creditContract.interface.parseLog(log);
//             } catch (e) {
//                 return null;
//             }
//         })
//         .find(parsedLog => parsedLog && parsedLog.name === "LoanRequested");

//     if (!event) throw new Error("Gagal mendapatkan loanId");
//     return event.args.loanId.toString();
// }

// async function payCredit(loanId, amount) {
//     const signer = await connectMetaMask();
//     const tokenContract = new ethers.Contract(rupiahTokenAddress, tokenAbi, signer);
//     const creditContract = new ethers.Contract(creditSystemAddress, creditAbi, signer);

//     const approveTx = await tokenContract.approve(creditSystemAddress, ethers.utils.parseEther(amount.toString()));
//     await approveTx.wait();

//     const payTx = await creditContract.payLoan(loanId, ethers.utils.parseEther(amount.toString()));
//     await payTx.wait();
//     console.log("Pinjaman dibayar!");
// }

// // Ekspor ke global scope untuk inline script
// window.connectMetaMask = connectMetaMask;
// window.requestCredit = requestCredit;
// window.payCredit = payCredit;

// console.log('connectMetaMask defined:', typeof window.connectMetaMask);
