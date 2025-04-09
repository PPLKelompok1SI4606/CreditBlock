// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

import "@openzeppelin/contracts/token/ERC20/IERC20.sol";

contract CreditSystem {
    address public admin;
    IERC20 public rupiahToken;
    mapping(address => uint256) public creditRequests;
    mapping(address => bool) public approvedCredits;

    event CreditRequested(address indexed user, uint256 amount);
    event CreditApproved(address indexed user, uint256 amount);

    constructor(address _rupiahToken) {
        admin = msg.sender;
        rupiahToken = IERC20(_rupiahToken);
    }

    function requestCredit(uint256 amount) external {
        creditRequests[msg.sender] = amount;
        emit CreditRequested(msg.sender, amount);
    }

    function approveCredit(address user) external {
        require(msg.sender == admin, "Only admin can approve");
        approvedCredits[user] = true;
        emit CreditApproved(user, creditRequests[user]);
    }

    function payCredit(uint256 amount) external {
        require(approvedCredits[msg.sender], "Credit not approved");
        require(rupiahToken.transferFrom(msg.sender, address(this), amount), "Payment failed");
        creditRequests[msg.sender] -= amount;
        if (creditRequests[msg.sender] == 0) {
            approvedCredits[msg.sender] = false;
        }
    }

    function getCreditAmount(address user) external view returns (uint256) {
        return creditRequests[user];
    }
}