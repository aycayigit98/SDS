from web3 import Web3
import json
import time

# Specify the path to your ABI file
abi_file_path = './bin/contracts/DonationSystemDemo.abi'
with open(abi_file_path, 'r') as abi_file:
    abi_contents = json.load(abi_file)

bin_file_path = "./bin/contracts/DonationSystemDemo.bin"
with open(bin_file_path, "r") as bin_file:
    bin_content = bin_file.read()

def deploy_contract():
    # Connect to a local Ethereum node
    web3 = Web3(Web3.HTTPProvider('HTTP://127.0.0.1:7545'))  # Update with your node URL

    # Set the default account
    web3.eth.default_account = web3.eth.accounts[0]  # Update with your desired account
    print("Default Account:", web3.eth.default_account)

    # Deploy the contract
    Contract = web3.eth.contract(abi=abi_contents, bytecode=bin_content)
    tx_hash = Contract.constructor().transact({"from": web3.eth.default_account})

    # Wait for the transaction to be mined
    while True:
        tx_receipt = web3.eth.getTransactionReceipt(tx_hash)
        if tx_receipt is not None:
            break
        time.sleep(1)

    # Retrieve the deployed contract's address
    contract_address = tx_receipt["contractAddress"]

    return contract_address

# Deploy the contract and print the contract address
contract_address = deploy_contract()
print("Contract deployed at address:", contract_address)
