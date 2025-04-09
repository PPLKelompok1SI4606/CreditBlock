async function main() {
  const RupiahToken = await ethers.getContractFactory("RupiahToken");
  const rupiahToken = await RupiahToken.deploy();
  await rupiahToken.deployed();
  console.log("RupiahToken deployed to:", rupiahToken.address);

  const CreditSystem = await ethers.getContractFactory("CreditSystem");
  const creditSystem = await CreditSystem.deploy(rupiahToken.address);
  await creditSystem.deployed();
  console.log("CreditSystem deployed to:", creditSystem.address);
}

module.exports = main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});