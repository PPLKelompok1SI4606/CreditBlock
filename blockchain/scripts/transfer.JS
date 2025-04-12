async function main() {
  const RupiahToken = await ethers.getContractFactory("RupiahToken");
  const rupiahToken = await RupiahToken.attach("0x23D184647fE15da049948015b450437506D6cE87"); // Replace with actual contract address
  const [admin] = await ethers.getSigners();
  await rupiahToken.transfer("0x38cEA110F24eA18A6cdd3761dFDd68Ff16bF9121", ethers.utils.parseEther("10000")); // Replace with actual MetaMask address
  console.log("Transferred 10,000 IDRT");
}

main()
  // .then(() => process.exit(0))
  .catch((error) => {
    console.error(error);
    process.exitCode = 1; // Fixed: Removed extra parenthesis
  });