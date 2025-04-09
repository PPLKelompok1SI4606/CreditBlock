async function main() {
  const RupiahToken = await ethers.getContractFactory("RupiahToken");
  const rupiahToken = await RupiahToken.attach("0x573B2636D3F8cF891C31953f72992436E98638f9"); // Replace with actual contract address
  const [admin] = await ethers.getSigners();
  await rupiahToken.transfer("0x3ee77ce1f6aCee06a013eA0992E9Af934fa03683", ethers.utils.parseEther("10000")); // Replace with actual MetaMask address
  console.log("Transferred 10,000 IDRT");
}

main()
  .then(() => process.exit(0))
  .catch((error) => {
    console.error(error);
    process.exitCode = 1; // Fixed: Removed extra parenthesis
  });