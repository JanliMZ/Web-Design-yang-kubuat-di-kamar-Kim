from flask import Flask, render_template, request, redirect, url_for, session
from flask import jsonify  
import pandas as pd
from flask import Flask
from flask_cors import CORS
app = Flask(__name__)
CORS(app)
from flask import jsonify
from sqlalchemy import create_engine, text
from sqlalchemy.orm import Session

# Replace 'username', 'password', 'localhost', 'database_name' with the appropriate values
engine = create_engine('mysql+mysqldb://newuser:password@localhost:3308/news')


print("ja")


@app.route('/')
def home():
    return "Welcome to the Online News Website"

@app.route('/register', methods=['POST'])
def register():
    print(request.form)
    data=request.form
    conn = engine.connect()
    first_name = data.get('fname')
    last_name = data.get('lname')
    email=data.get('email')
    password = data.get('psw')
    query = text('SELECT * from users')

    users = pd.read_sql(query, conn)
    
    if len(users)>0:
        for user in users:
            if user['email'] == email:
                return jsonify({'success': False}), 401
    sql=text("insert into users (f_name, l_name, email, password) values('"+first_name+"', '"+last_name+"', '"+email+"', '"+password+"')")
    session = Session(bind=engine)
    #engine.execute(sql)
    session.execute(sql)
    session.commit()
    session.close()
    conn.close()
    return jsonify({'success': True, 'message': 'okk'}), 200



@app.route('/login', methods=['POST'])
def login():
    conn = engine.connect()
    print(request.form)
    username = request.form.get('email')
    password = request.form.get('psw')
    print(username)
    print(password)
    query = text('SELECT * from users')

    users = pd.read_sql(query, conn)
    conn.close()
    for _,user in users.iterrows():
        if user['email'] == username and user['password'] == password:
            return jsonify({'message': "okk"}), 200
        return jsonify({'error':'Invalid Credentials'}), 401


@app.route('/dashboard')
def dashboard():
    if 'user_id' in session:
        return "Welcome to the dashboard. You are logged in!"
    else:
        return "You are not logged in."

@app.route('/subscribe', methods=['POST'])
def subscribe():
    # Implement subscription logic here
    return "Subscribed successfully!"

if __name__ == '__main__':
    app.run(debug=True)
