from pymongo import MongoClient
import hashlib
import sys

# MongoDB Atlas connection details
cluster_uri = "mongodb+srv://amritalodh:Amritosanto0@amrito.sbi230b.mongodb.net/?retryWrites=true&w=majority"
client = MongoClient(cluster_uri)
db = client['blockchain_db']
collection = db['blocks']

def check_hash(provided_hash):
    # Search for the document with the given index
    document = collection.find_one({"data_hash": provided_hash})

    stored_hash = document.get("data_hash")
    if provided_hash == stored_hash:
        return "Hashes match: True"
    else:
        return "Hashes do not match: False"

def calculate_hash(data):
    if isinstance(data, str):
        # If the data is a text string, encode it as bytes before hashing
        data = data.encode()
    return hashlib.sha256(data).hexdigest()

def main(file_path):
    try:
        with open(file_path, 'rb') as file:
            file_data = file.read()
            provided_hash = calculate_hash(file_data)
        result = check_hash(provided_hash)
        return result
    except ValueError:
        return "Invalid input. Please enter a valid input."

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python main2.py <file_path>")
        sys.exit(1)

    file_path = sys.argv[1]
    result = main(file_path)
    print(result)
