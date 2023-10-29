from flask import Flask, render_template, request, redirect, flash
import os
import subprocess
from pymongo import MongoClient

app = Flask(__name__)
app.secret_key = 'helloworld'  # Change this to a secure secret key.

# MongoDB Atlas connection details
cluster_uri = "mongodb+srv://amritalodh:Amritosanto0@amrito.sbi230b.mongodb.net/?retryWrites=true&w=majority"
client = MongoClient(cluster_uri)
db = client['blockchain_db']
collection = db['blocks']

def check_hash(index, provided_hash):
    # Your existing check_hash function here
    document = collection.find_one({"index": index})

    if document:
        stored_hash = document.get("data_hash")
        if provided_hash == stored_hash:
            return "Hashes match: True"
        else:
            return "Hashes do not match: False"
    else:
        return f"No document found with index {index}"

@app.route('/')
def index():
    return render_template('upload.html')

@app.route('/upload', methods=['POST'])
def upload_file():
    if 'pdf_file' not in request.files:
        flash('No file part')
        return redirect(request.url)

    pdf_file = request.files['pdf_file']

    if pdf_file.filename == '':
        flash('No selected file')
        return redirect(request.url)

    if pdf_file:
        # Save the uploaded PDF file to a temporary directory
        upload_folder = 'temp_uploads'  # Create a 'temp_uploads' directory
        os.makedirs(upload_folder, exist_ok=True)
        pdf_file_path = os.path.join(upload_folder, pdf_file.filename)
        pdf_file.save(pdf_file_path)

        try:
            # Call your script to process the PDF file
            script_result = subprocess.run(['python', 'main.py', pdf_file_path], capture_output=True, text=True)
            script_output = script_result.stdout
            script_error = script_result.stderr
            # You can do something with the script output or error if needed.
            
            # Implement your logic to extract index and provided_hash from script_output
            index = 1  # Replace with your logic to get the index
            provided_hash = "some_hash"  # Replace with your logic to get the provided hash

            # Call your check_hash function
            result = check_hash(index, provided_hash)

        except Exception as e:
            flash(f'Error: {str(e)}')
        finally:
            os.remove(pdf_file_path)  # Remove the uploaded PDF after processing

    return render_template('upload.html', result=result)

@app.route('/check', methods=['GET', 'POST'])
def check_pdf():
    if request.method == 'POST':
        pdf_file = request.files['pdf_file']
        # index = request.form['index']

        if pdf_file:
            # Save the uploaded PDF file to a temporary directory
            upload_folder = 'temp_uploads'
            os.makedirs(upload_folder, exist_ok=True)
            pdf_file_path = os.path.join(upload_folder, pdf_file.filename)
            pdf_file.save(pdf_file_path)

            try:
                # Call main2.py to process the PDF file
                script_result = subprocess.run(['python', 'main2.py', pdf_file_path], capture_output=True, text=True)
                script_output = script_result.stdout
                script_error = script_result.stderr

            except Exception as e:
                flash(f'Error: {str(e)}')
            finally:
                os.remove(pdf_file_path)  # Remove the uploaded PDF after processing

            return render_template('check.html', result=script_output)

    return render_template('check.html', result=None)

if __name__ == '__main__':
    app.run(debug=True)
