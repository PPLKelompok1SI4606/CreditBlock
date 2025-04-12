import { ethers } from "ethers";

const rupiahTokenAddress = "0x23D184647fE15da049948015b450437506D6cE87"; // Ganti dari deploy
const creditSystemAddress = "0x4F5C56710B3c4F51777B7fd3a6E8773c57e9eaA2"; // Ganti dari deploy
const tokenAbi = require('../../blockchain/artifacts/contracts/RupiahToken.sol/RupiahToken.json').abi;
const creditAbi = require('../../blockchain/artifacts/contracts/CreditSystem.sol/CreditSystem.json').abi;

async function connectMetaMask() {
    if (window.ethereum) {
        await window.ethereum.request({ method: "eth_requestAccounts" });
        const provider = new ethers.providers.Web3Provider(window.ethereum);
        return provider.getSigner();
    }
    alert("Install MetaMask!");
}

async function requestCredit(amount) {
    const signer = await connectMetaMask();
    const creditContract = new ethers.Contract(creditSystemAddress, creditAbi, signer);
    const tx = await creditContract.requestCredit(ethers.utils.parseEther(amount.toString()));
    await tx.wait();
    console.log("Credit requested!");
}

async function payCredit(amount) {
    const signer = await connectMetaMask();
    const tokenContract = new ethers.Contract(rupiahTokenAddress, tokenAbi, signer);
    const creditContract = new ethers.Contract(creditSystemAddress, creditAbi, signer);

    const approveTx = await tokenContract.approve(creditSystemAddress, ethers.utils.parseEther(amount.toString()));
    await approveTx.wait();

    const payTx = await creditContract.payCredit(ethers.utils.parseEther(amount.toString()));
    await payTx.wait();
    console.log("Credit paid!");
}

document.getElementById("requestButton").addEventListener("click", () => requestCredit(10000));
document.getElementById("payButton").addEventListener("click", () => payCredit(10000));
