//SPDX-License-Identifier: GPL-3.0
pragma solidity >=0.8.2 <0.9.0;
import "hardhat/console.sol";

contract DonationSystemDemo {
    struct DonationRequest {
        address student;
        string name;
        string description;
        uint256 amount;
        bool isApproved;
        bool isPaid;
    }

    struct Donation {
        address sender;
        address receiver;
        uint256 amount;
        uint datetime;
    }

    struct Admin {
        bool exists;
    }

    struct Donor {
        bool exists;
        uint256 balance;
        uint256[] donationIds;  
    }

    struct Student {
        bool exists;
        mapping(uint256 => DonationRequest) requests;
        mapping(uint256 => Donation) donations;
        uint256[] requestIds;
        uint256[] donationIds;
        uint256 balance;
    }

    mapping(address => Admin) public admins;
    mapping(address => Donor) public donors;
    mapping(address => Student) public students;
    mapping(address => uint256) public balances;
    mapping(uint256 => address) donationId2Student;
    uint256 public nextRequestId;
    uint256 public nextDonationId;

    event RequestCreated(address indexed student, uint256 requestId, string name, string description, uint256 amount);
    event RequestApproved(address indexed admin, uint256 requestId);
    event DonationMade(address indexed donor, uint256 requestId, uint256 amount);
    event AdminAdded(address indexed admin);
    event AdminRemoved(address indexed admin);
    event DonorAdded(address indexed donor);
    event DonorRemoved(address indexed donor);
    event StudentAdded(address indexed student);
    event StudentRemoved(address indexed student);
    event DonorConvertedToAdmin(address indexed donor);

    modifier onlyAdmin() {
        require(admins[msg.sender].exists, "Only admins can perform this action.");
        _;
    }

    modifier onlyStudent() {
        require(students[msg.sender].exists, "Only students can perform this action.");
        _;
    }

    modifier onlyDonor() {
        require(donors[msg.sender].exists, "Only donors can perform this action.");
        _;
    }

    constructor() {
        admins[msg.sender].exists = true;
        nextRequestId = 1;
        nextDonationId = 1;
    }

    function addAdmin(address _admin) public onlyAdmin {
        require(!students[_admin].exists, "You cannot make a student an admin.");
        admins[_admin].exists = true;

        emit DonorConvertedToAdmin(_admin);
    }

    function removeAdmin(address _admin) public onlyAdmin {
        require(msg.sender != _admin, "You cannot remove yourself as an admin.");
        admins[_admin].exists = false;
    }

    function addDonor(address _donor) public onlyAdmin {
        require(!donors[_donor].exists, "Donor already exists.");
        donors[_donor].exists = true;

        emit DonorAdded(_donor);
    }

    function removeDonor(address _donor) public onlyAdmin {
        require(donors[_donor].exists, "Donor does not exist.");
        delete donors[_donor];

        emit DonorRemoved(_donor);
    }

    function addStudent(address _student) public onlyAdmin {
        require(!students[_student].exists, "Student already exists.");
        students[_student].exists = true;

        emit StudentAdded(_student);
    }

    function removeStudent(address _student) public onlyAdmin {
        require(students[_student].exists, "Student does not exist.");
        delete students[_student];

        emit StudentRemoved(_student);
    }

    function createRequest(string memory _name, string memory _description, uint256 _amount) public onlyStudent {
        require(_amount > 0, "Amount should be greater than zero.");

        uint256 requestId = nextRequestId;
        nextRequestId++;
        DonationRequest storage request = students[msg.sender].requests[requestId];
        request.student = msg.sender;
        request.name = _name;
        request.description = _description;
        request.amount = _amount;

        students[msg.sender].requestIds.push(requestId);

        emit RequestCreated(msg.sender, requestId, _name, _description, _amount);
    }

    function approveRequest(uint256 _requestId, address _student) public onlyAdmin {
        require(admins[msg.sender].exists, "Only admins can approve requests.");
        require(students[_student].exists, "Student does not exist.");
        require(students[_student].requests[_requestId].student != address(0), "Request does not exist.");
        require(!students[_student].requests[_requestId].isApproved, "Request is already approved.");

        students[_student].requests[_requestId].isApproved = true;

        emit RequestApproved(msg.sender, _requestId);
    }

    function donateToRequest(uint256 _requestId, address _student) public payable onlyDonor {
        require(students[_student].exists, "Only donors can make donations.");
        require(students[_student].requests[_requestId].student != address(0), "Request does not exist.");
        require(students[_student].requests[_requestId].isApproved, "Request is not approved yet.");
        require(!students[students[_student].requests[_requestId].student].requests[_requestId].isPaid, "Request is already paid.");
        require(msg.value > 0, "Donation amount should be greater than zero.");

        address payable studentAddress = payable(students[_student].requests[_requestId].student);

        if (msg.value >= students[_student].requests[_requestId].amount) {
            students[_student].requests[_requestId].isPaid = true;
            students[_student].balance += students[_student].requests[_requestId].amount;

            emit DonationMade(msg.sender, _requestId, students[_student].requests[_requestId].amount);
        } else {
            students[_student].requests[_requestId].amount -= msg.value;
            students[_student].balance += msg.value;

            emit DonationMade(msg.sender, _requestId, msg.value);
        }

        studentAddress.transfer(msg.value);
        uint256 donationId = nextDonationId;
        nextDonationId++;
        Donation storage donation = students[_student].donations[donationId];
        donation.sender = msg.sender;
        donation.receiver = _student;
        donation.amount = msg.value;
        donation.datetime = block.timestamp;
        students[_student].donationIds.push(donationId);
        donationId2Student[donationId] = _student;
        donors[msg.sender].donationIds.push(donationId);
    }

    function getStudentRequests(address _student) public view returns (uint256[] memory, DonationRequest[] memory) {
        require(students[_student].exists, "Student does not exist.");
        uint256[] memory requestIds = students[_student].requestIds;
        DonationRequest[] memory requests = new DonationRequest[](requestIds.length);

        for (uint256 i = 0; i < requestIds.length; i++) {
            requests[i] = students[_student].requests[requestIds[i]];
        }

        return (requestIds, requests);
    }

    function getStudentDonations(address _student) public view returns (uint256[] memory, Donation[] memory) {
        require(students[_student].exists, "Student does not exist.");
        uint256[] memory donationIds = students[_student].donationIds;
        Donation[] memory donations = new Donation[](donationIds.length);

       for (uint256 i = 0; i < donationIds.length; i++) {
            donations[i] = students[_student].donations[donationIds[i]];
        }

        return (donationIds, donations);
    }

    function getDonorDonations(address _donor) public view returns (uint256[] memory, Donation[] memory){
        require(donors[_donor].exists, "Donor does not exist.");
        uint256[] memory donationIds = donors[_donor].donationIds;
        Donation[] memory donations = new Donation[](donationIds.length);

       for (uint256 i = 0; i < donationIds.length; i++) {
            donations[i] = students[donationId2Student[donationIds[i]]].donations[donationIds[i]];
        }

        return (donationIds, donations);
    }

    function getBalance() external view returns (uint256) {
        return address(this).balance;
    }

    receive() external payable {}
}
