// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

import "@openzeppelin/contracts/token/ERC20/IERC20.sol";

interface IRupiahToken {
    function transfer(address recipient, uint256 amount) external returns (bool);
    function transferFrom(address sender, address recipient, uint256 amount) external returns (bool);
    function balanceOf(address account) external view returns (uint256);
    function approve(address spender, uint256 amount) external returns (bool);
}

contract CreditSystem {
    address public admin;
    IRupiahToken public rupiahToken;
    uint256 public loanCounter;

    enum LoanStatus { PENDING, APPROVED, REJECTED, PAID }
    
    struct Loan {
        uint256 id;
        address borrower;
        uint256 amount;
        uint256 duration; // dalam bulan
        LoanStatus status;
        uint256 createdAt;
        uint256 amountPaid;
    }

    mapping(uint256 => Loan) public loans;
    mapping(address => bool) public isAdmin;

    event LoanRequested(uint256 indexed loanId, address indexed borrower, uint256 amount, uint256 duration);
    event LoanStatusUpdated(uint256 indexed loanId, LoanStatus status);
    event LoanPaid(uint256 indexed loanId, address indexed borrower, uint256 amount);
    event AdminAdded(address indexed newAdmin);
    event AdminRemoved(address indexed removedAdmin);

    modifier onlyAdmin() {
        require(isAdmin[msg.sender] || msg.sender == admin, "Hanya admin yang bisa melakukan ini");
        _;
    }

    constructor(address _rupiahTokenAddress) {
        admin = msg.sender;
        isAdmin[msg.sender] = true;
        rupiahToken = IRupiahToken(_rupiahTokenAddress);
        loanCounter = 0;
    }

    function addAdmin(address _newAdmin) external onlyAdmin {
        require(_newAdmin != address(0), "Alamat tidak valid");
        require(!isAdmin[_newAdmin], "Alamat sudah admin");
        isAdmin[_newAdmin] = true;
        emit AdminAdded(_newAdmin);
    }

    function removeAdmin(address _admin) external onlyAdmin {
        require(_admin != admin, "Admin utama tidak bisa dihapus");
        require(isAdmin[_admin], "Alamat bukan admin");
        isAdmin[_admin] = false;
        emit AdminRemoved(_admin);
    }

    function requestLoan(uint256 _amount, uint256 _duration) external {
        require(_amount > 0, "Jumlah harus lebih dari 0");
        require(_duration >= 1 && _duration <= 60, "Durasi harus antara 1-60 bulan");

        loanCounter++;
        loans[loanCounter] = Loan({
            id: loanCounter,
            borrower: msg.sender,
            amount: _amount,
            duration: _duration,
            status: LoanStatus.PENDING,
            createdAt: block.timestamp,
            amountPaid: 0
        });

        emit LoanRequested(loanCounter, msg.sender, _amount, _duration);
    }

    function updateLoanStatus(uint256 _loanId, bool _approve) external onlyAdmin {
        require(_loanId > 0 && _loanId <= loanCounter, "ID pinjaman tidak valid");
        Loan storage loan = loans[_loanId];
        require(loan.status == LoanStatus.PENDING, "Pinjaman harus berstatus PENDING");

        if (_approve) {
            loan.status = LoanStatus.APPROVED;
        } else {
            loan.status = LoanStatus.REJECTED;
        }

        emit LoanStatusUpdated(_loanId, loan.status);
    }

    function payLoan(uint256 _loanId, uint256 _amount) external {
        require(_loanId > 0 && _loanId <= loanCounter, "ID pinjaman tidak valid");
        Loan storage loan = loans[_loanId];
        require(loan.status == LoanStatus.APPROVED, "Pinjaman harus disetujui");
        require(loan.borrower == msg.sender, "Hanya peminjam yang bisa membayar");
        require(_amount > 0, "Jumlah pembayaran harus lebih dari 0");
        require(loan.amountPaid + _amount <= loan.amount, "Pembayaran melebihi jumlah pinjaman");

        require(rupiahToken.transferFrom(msg.sender, address(this), _amount), "Transfer token gagal");
        loan.amountPaid += _amount;

        if (loan.amountPaid == loan.amount) {
            loan.status = LoanStatus.PAID;
        }

        emit LoanPaid(_loanId, msg.sender, _amount);
    }

    function getLoan(uint256 _loanId) external view returns (
        uint256 id,
        address borrower,
        uint256 amount,
        uint256 duration,
        LoanStatus status,
        uint256 createdAt,
        uint256 amountPaid
    ) {
        require(_loanId > 0 && _loanId <= loanCounter, "ID pinjaman tidak valid");
        Loan memory loan = loans[_loanId];
        return (
            loan.id,
            loan.borrower,
            loan.amount,
            loan.duration,
            loan.status,
            loan.createdAt,
            loan.amountPaid
        );
    }
}