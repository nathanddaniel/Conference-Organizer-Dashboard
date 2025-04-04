DROP DATABASE IF EXISTS conferenceDB;
CREATE DATABASE if NOT EXISTS conferenceDB;
USE conferenceDB;

/* Creating tables for all the strong entities */
CREATE TABLE Attendee (
    attendee_id CHAR(11) NOT NULL,
    fee DECIMAL(10,2) NOT NULL,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    PRIMARY KEY (attendee_id)
);

CREATE TABLE Student (
    attendee_id CHAR(11) NOT NULL,
    PRIMARY KEY (attendee_id),
    FOREIGN KEY (attendee_id) REFERENCES Attendee(attendee_id) ON DELETE CASCADE
);

/* For the rooms # im assuming that the room number is all integers and not something like 67A */
CREATE TABLE Room (
    num INT NOT NULL,
    num_beds INT NOT NULL,
    PRIMARY KEY (num)
);

CREATE TABLE Professional (
    attendee_id CHAR(11) NOT NULL,
    PRIMARY KEY (attendee_id),
    FOREIGN KEY (attendee_id) REFERENCES Attendee(attendee_id) ON DELETE CASCADE
);

CREATE TABLE Sponsor (
    attendee_id CHAR(11) NOT NULL,
    PRIMARY KEY (attendee_id),
    FOREIGN KEY (attendee_id) REFERENCES Attendee(attendee_id) ON DELETE CASCADE
);

CREATE TABLE Speaker (
    attendee_id CHAR(11) NOT NULL,
    PRIMARY KEY (attendee_id),
    FOREIGN KEY (attendee_id) REFERENCES Attendee(attendee_id) ON DELETE CASCADE
);

CREATE TABLE ConferenceSession (
    session_location VARCHAR(100) NOT NULL,
    session_date DATE NOT NULL,
    stime TIME NOT NULL,
    etime TIME NOT NULL,
    PRIMARY KEY (session_location, session_date, stime)
);

CREATE TABLE Company (
    company_name VARCHAR(100) NOT NULL,
    emails_sent INT, 
    sponsorship_level VARCHAR(50) NOT NULL, 
    PRIMARY KEY (company_name)
);

CREATE TABLE Subcommittee (
    subcommittee_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (subcommittee_name)
);

CREATE TABLE Member (
    member_id CHAR(11) NOT NULL,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    PRIMARY KEY (member_id)
);

/* Creating tables for all the weak entities */
CREATE TABLE JobAd (
    title VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    job_location VARCHAR(100) NOT NULL,
    company_name VARCHAR(100) NOT NULL, 
    PRIMARY KEY (title, company_name), 
    FOREIGN KEY (company_name) REFERENCES Company(company_name) ON DELETE CASCADE
);

/* Creating relations for N:M relationships */
CREATE TABLE Subcommittee_Member (
    subcommittee_name       VARCHAR(100) NOT NULL,
    member_id               CHAR(11) NOT NULL,

    PRIMARY KEY (subcommittee_name, member_id),
    FOREIGN KEY (subcommittee_name) REFERENCES Subcommittee(subcommittee_name) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES Member(member_id) ON DELETE CASCADE
);

/* Altering tables for 1:N relationships */
ALTER TABLE Student 
ADD COLUMN room_num INT NULL,
ADD FOREIGN KEY (room_num) REFERENCES Room(num) ON DELETE SET NULL;

ALTER TABLE Sponsor
ADD COLUMN company_name VARCHAR(100) NOT NULL,
ADD FOREIGN KEY (company_name) REFERENCES Company(company_name) ON DELETE CASCADE;

/* Altering for 1:1 Relationships */
ALTER TABLE ConferenceSession
ADD COLUMN speaker_id CHAR(11) NOT NULL UNIQUE,
ADD FOREIGN KEY (speaker_id) REFERENCES Speaker(attendee_id) ON DELETE CASCADE;

ALTER TABLE Subcommittee
ADD COLUMN chair_id CHAR(11) NOT NULL UNIQUE,
ADD FOREIGN KEY (chair_id) REFERENCES Member(member_id) ON DELETE CASCADE;

/* Inserting data for each table */
INSERT INTO Attendee VALUES
('ATT00000001', 50.00, 'Lucas', 'Srigley'),
('ATT00000002', 50.00, 'Matthew', 'Divito'),
('ATT00000003', 50.00, 'Cole', 'Miklaucic'),
('ATT00000004', 50.00, 'Jack', 'Rankel'),
('ATT00000005', 50.00, 'Anson', 'Ling'),
('ATT00000006', 50.00, 'Ryan', 'Strong'),
('ATT00000007', 100.00, 'Conrad', 'Bierman'),
('ATT00000008', 100.00, 'JT', 'Wang'),
('ATT00000009', 100.00, 'Jacob', 'Antonious'),
('ATT00000010', 100.00, 'Sohan', 'Kolla'),
('ATT00000011', 100.00, 'Freeman', 'Sayo'),
('ATT00000012', 100.00, 'Tristan', 'Gueverra'),
('ATT00000013', 0.00, 'Calvin', 'Birch'),
('ATT00000014', 0.00, 'Justin', 'Lan'),
('ATT00000015', 0.00, 'Ben', 'Mack'),
('ATT00000016', 0.00, 'Travis', 'Kelce'),
('ATT00000017', 0.00, 'Rashee', 'Rice'),
('ATT00000018', 0.00, 'Skyy', 'Moore'),
('ATT00000019', 80.00, 'Xavier', 'Worthy'),
('ATT00000020', 80.00, 'Justin', 'Watson'),
('ATT00000021', 80.00, 'Mecole', 'Hardman'),
('ATT00000022', 80.00, 'Justyn', 'Ross'),
('ATT00000023', 80.00, 'Nikko', 'Remigio'),
('ATT00000024', 80.00, 'Adam', 'Gold');

INSERT INTO Room VALUES
(101, 2),  
(102, 2),  
(103, 1),  
(104, 2),  
(105, 1),  
(106, 1),  
(107, 2),  
(108, 2);  

INSERT INTO Student VALUES
('ATT00000001', 101),
('ATT00000002', 102),
('ATT00000003', NULL),
('ATT00000004', 103),
('ATT00000005', 101),
('ATT00000006', NULL);

INSERT INTO Professional VALUES
('ATT00000007'),
('ATT00000008'),
('ATT00000009'),
('ATT00000010'),
('ATT00000011'),
('ATT00000012');

INSERT INTO Company VALUES
('Google', 5, 'Platinum'),
('Apple', 5, 'Platinum'),
('Stripe', 4, 'Gold'),
('Meta', 4, 'Gold'),
('Uber', 3, 'Silver'),
('Snapchat', NULL, 'Bronze');

INSERT INTO Sponsor VALUES
('ATT00000013', 'Google'),
('ATT00000014', 'Apple'),
('ATT00000015', 'Stripe'),
('ATT00000016', 'Meta'),
('ATT00000017', 'Uber'),
('ATT00000018', 'Snapchat');

INSERT INTO Speaker VALUES
('ATT00000019'),
('ATT00000020'),
('ATT00000021'),
('ATT00000022'),
('ATT00000023'),
('ATT00000024');

INSERT INTO ConferenceSession VALUES
('Room A', '2025-02-10', '09:00:00', '10:30:00', 'ATT00000019'),
('Room B', '2025-02-10', '11:00:00', '12:30:00', 'ATT00000020'),
('Room C', '2025-02-11', '13:00:00', '14:30:00', 'ATT00000021'),
('Room D', '2025-02-11', '15:00:00', '16:30:00', 'ATT00000022'),
('Room E', '2025-02-12', '10:00:00', '11:30:00', 'ATT00000023'),
('Room F', '2025-02-12', '14:00:00', '15:30:00', 'ATT00000024');

INSERT INTO JobAd VALUES
('Software Engineer', 120000, 'Toronto, ON', 'Google'),
('Machine Learning Engineer', 130000, 'Vancouver, BC', 'Apple'),
('Data Scientist', 115000, 'Calgary, AB', 'Stripe'),
('Backend Engineer', 110000, 'Toronto, ON', 'Meta'),
('Cloud Engineer', 105000, 'Montreal, QB', 'Uber'),
('Product Designer', 100000, 'Ottawa, ON', 'Snapchat');

INSERT INTO Member VALUES
('M001', 'Sarah', 'White'),
('M002', 'James', 'Harris'),
('M003', 'Robert', 'Clark'),
('M004', 'Emily', 'Martinez'),
('M005', 'William', 'Moore'),
('M006', 'Linda', 'Anderson'),
('M007', 'Thomas', 'Taylor'),
('M008', 'Barbara', 'Jackson'),
('M009', 'Kevin', 'Nelson'),
('M010', 'Jessica', 'Peterson');

INSERT INTO Subcommittee VALUES
('Tech Innovations', 'M001'),
('AI & Ethics', 'M002'),
('Cybersecurity Task Force', 'M003'),
('Cloud Computing Panel', 'M004'),
('Data Science & Analytics', 'M005'),
('Software Development Standards', 'M006');

INSERT INTO Subcommittee_Member VALUES
('Tech Innovations', 'M001'),
('Tech Innovations', 'M005'),
('Tech Innovations', 'M009'),
('AI & Ethics', 'M002'),
('AI & Ethics', 'M006'),
('AI & Ethics', 'M010'),
('Cybersecurity Task Force', 'M003'),
('Cybersecurity Task Force', 'M007'),
('Cybersecurity Task Force', 'M009'),
('Cloud Computing Panel', 'M004'),
('Cloud Computing Panel', 'M005'),
('Cloud Computing Panel', 'M008'),
('Data Science & Analytics', 'M005'),
('Data Science & Analytics', 'M007'),
('Data Science & Analytics', 'M010'),
('Software Development Standards', 'M006'),
('Software Development Standards', 'M008'),
('Software Development Standards', 'M009');