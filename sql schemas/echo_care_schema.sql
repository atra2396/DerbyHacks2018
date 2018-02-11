CREATE TABLE nurses (		n_id int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				n_name varchar(30) NOT NULL, 
				n_phone varchar(20) NOT NULL, 
				n_email varchar(50) NOT NULL,
				n_password varchar(32) NOT NULL,  
				n_location varchar(50) NOT NULL);

CREATE TABLE meds (		m_id int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				m_name varchar(30) NOT NULL, 
				m_directions varchar(280) NOT NULL, 
				m_dosage varchar(20) NOT NULL, 
				m_priority varchar(20) NOT NULL);

CREATE TABLE questions (	q_id int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				q_text varchar(280) NOT NULL);

CREATE TABLE patients (         p_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                p_name varchar(20) NOT NULL,
                                p_phone varchar(20) NOT NULL,
                                p_email varchar(50) NOT NULL,
                                p_location varchar(50) NOT NULL,
                                n_id int NOT NULL);

CREATE TABLE conditions (	c_id int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				c_name varchar(20) NOT NULL,
				p_id int NOT NULL,
				m_id int NOT NULL);

CREATE TABLE alerts (		a_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
				a_start_date date NOT NULL,
				a_frequency varchar(20) NOT NULL, 
				p_id int NOT NULL, 
				m_id int, 
				q_id int);
