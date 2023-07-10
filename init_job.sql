DROP DATABASE IF EXISTS jobconnect;
CREATE DATABASE jobconnect;
\c jobconnect
SET client_encoding = 'UTF8';
DROP TABLE IF EXISTS jobseeker, gakureki, skill, employer, joblist, jobapp, saved_job, saved_candidates, user_login, emp_login;
CREATE EXTENSION IF NOT EXISTS pgcrypto; -- required for hash functions
CREATE EXTENSION IF NOT EXISTS unaccent; -- truy van tim kiem bo qua dau trong am
---------------------------------------------
-- Sign in information
CREATE TABLE user_login (
    email VARCHAR(100) PRIMARY KEY,
    pwdHashed VARCHAR(666),
    salt VARCHAR(666)
);

CREATE TABLE emp_login (
    email VARCHAR(100) PRIMARY KEY,
    pwdHashed VARCHAR(666),
    salt VARCHAR(666)
);

--------------------------------------------------------------------------------
-- Information of Job Seekers
CREATE TYPE visibility AS ENUM ('Public', 'ApplicationOnly');
CREATE TYPE segg AS ENUM ('Male', 'Female'); -- No Other, Enby, etc
CREATE TABLE jobseeker (
    fullName VARCHAR(30),
    dob DATE,
    gender segg,
    email VARCHAR(100) PRIMARY KEY REFERENCES user_login(email),
    phoneNum VARCHAR(30),
    address VARCHAR(666) ,
    selfIntro VARCHAR(666),
    industry VARCHAR(50),
    isPrivate visibility DEFAULT 'ApplicationOnly'
);

CREATE TYPE label AS ENUM ('Degree', 'Cert');
CREATE TABLE gakureki (
    id SERIAL PRIMARY KEY,
    email VARCHAR(100) REFERENCES jobseeker(email),
    title VARCHAR(30) NOT NULL,
    type label NOT NULL,
    time_range VARCHAR(20),
    description VARCHAR(666) 
);

CREATE TABLE skill (
    id SERIAL PRIMARY KEY,
    email VARCHAR(100) REFERENCES jobseeker(email),
    title VARCHAR(30) ,
    description VARCHAR(666) 
);

---------------------------------------------
-- About Employer
CREATE TABLE employer (
    empName VARCHAR(80),
    address VARCHAR(666),
    email VARCHAR(100) PRIMARY KEY REFERENCES emp_login(email),
    phoneNum VARCHAR(30),
    website VARCHAR(666),
    industry VARCHAR(50),
    selfIntro VARCHAR(666) 
);
-- Each employer has opening and closed job positions.
CREATE TYPE jobStatus AS ENUM ('Hiring', 'Closed');
CREATE TABLE joblist (
    jid SERIAL PRIMARY KEY,
    email VARCHAR(100) REFERENCES employer(email),
    industry VARCHAR(50),
    job_title VARCHAR(50),
    job_description VARCHAR(500),
    salary_demand VARCHAR(20),
    exp_required VARCHAR(100),
    academic_required VARCHAR(100) ,
    location VARCHAR(666) ,
    posted_date DATE DEFAULT CURRENT_DATE,
    close_at DATE,
    status jobStatus DEFAULT 'Hiring',
    CONSTRAINT check_dates CHECK (close_at > posted_date)
);
-- Application Status of each Job Seeker
CREATE TYPE appStatus AS ENUM ('Pending', 'Accepted', 'Rejected');
CREATE TABLE jobapp (
    id SERIAL PRIMARY KEY,
    jid INTEGER REFERENCES joblist(jid),
    email VARCHAR(100) REFERENCES jobseeker(email),
    applied_date DATE DEFAULT CURRENT_DATE,
    status appStatus DEFAULT 'Pending'
);
---------------------------------------------
CREATE TABLE saved_jobs (
    email VARCHAR(100) REFERENCES jobseeker(email),
    jid INTEGER REFERENCES joblist(jid),
    description VARCHAR(666), 
    PRIMARY KEY (email, jid)
);

CREATE TABLE saved_candidates (
    email VARCHAR(100) REFERENCES employer(email),
    c_email VARCHAR(100) REFERENCES jobseeker(email),
    description VARCHAR(666),
    PRIMARY KEY (email, c_email)
);

/* PHAN QUYEN DUA TREN VAI TRO */
CREATE ROLE guest WITH PASSWORD 'nanika' LOGIN;
GRANT SELECT ON jobseeker, gakureki, skill, employer, joblist, user_login, emp_login TO guest;
GRANT INSERT ON jobseeker, employer, user_login, emp_login TO guest;

CREATE ROLE jobsk WITH PASSWORD 's3cur3p455w0rd' LOGIN;
GRANT SELECT ON jobseeker, gakureki, skill, employer, joblist, jobapp, saved_jobs, user_login, emp_login TO jobsk;
GRANT INSERT ON jobseeker, gakureki, skill, jobapp, saved_jobs TO jobsk;
GRANT UPDATE ON jobseeker, gakureki, skill, saved_jobs, user_login, emp_login;
GRANT DELETE ON gakureki, skill, saved_jobs TO jobsk;

CREATE ROLE emplr WITH PASSWORD 'd0ntm1ndm3' LOGIN;
GRANT SELECT ON jobseeker, gakureki, skill, employer, joblist, jobapp, saved_candidates, user_login, emp_login TO emplr;
GRANT INSERT ON joblist, saved_candidates TO emplr;
GRANT UPDATE ON employer, jobapp, saved_candidates, user_login, emp_login, jobapp TO emplr;
GRANT DELETE ON saved_candidates TO emplr;

/*********************** CREATE FUNCTIONS  *********************************
 *********************** CREATE PROCEDURES *********************************
 *********************** CREATE TRIGGERS   *********************************
 ****************************** HERE ***************************************/
CREATE OR REPLACE FUNCTION add_user(IN email VARCHAR(100), IN password VARCHAR(100))
RETURNS VOID AS $$
DECLARE
    salt VARCHAR(50);
BEGIN
    salt := gen_salt('bf', 8);
    INSERT INTO user_login VALUES (email, crypt(password, salt), salt);
    INSERT INTO jobseeker(email) VALUES (email);
END;
$$ LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION add_emp(IN email VARCHAR(100), IN password VARCHAR(100))
RETURNS VOID AS $$
DECLARE
    salt VARCHAR(50);
BEGIN
    salt := gen_salt('bf', 8);
    INSERT INTO emp_login VALUES (email, crypt(password, salt), salt);
    INSERT INTO employer(email) VALUES (email);
END;
$$ LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION verify_user(IN usr VARCHAR(100), IN password VARCHAR(100))
RETURNS BOOLEAN AS $$
DECLARE
    stored_password TEXT;
BEGIN
    SELECT pwdHashed INTO stored_password FROM user_login WHERE email = usr;
    RETURN stored_password = crypt(password, stored_password);
END;
$$ LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION verify_emp(IN usr VARCHAR(100), IN password VARCHAR(100))
RETURNS BOOLEAN AS $$
DECLARE
    stored_password TEXT;
BEGIN
    SELECT pwdHashed INTO stored_password FROM emp_login WHERE email = usr;
    RETURN stored_password = crypt(password, stored_password);
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE PROCEDURE add_job_advertisement(
    p_email VARCHAR(100),
    p_industry VARCHAR(20),
    p_job_title VARCHAR(50),
    p_job_description VARCHAR(500),
    p_salary_demand VARCHAR(20),
    p_exp_required VARCHAR(100),
    p_academic_required VARCHAR(100),
    p_location VARCHAR(666),
    p_close_at DATE
)
LANGUAGE plpgsql AS $$
BEGIN
    INSERT INTO joblist(email, industry, job_title, job_description, salary_demand, exp_required, academic_required, location, close_at)
    VALUES (p_email, p_industry, p_job_title, p_job_description, p_salary_demand, p_exp_required, p_academic_required, p_location, p_close_at);
END;
$$;

CREATE OR REPLACE PROCEDURE update_profile(

)

CREATE OR REPLACE PROCEDURE insert_jobsk_gakureki(
    p_email VARCHAR(100),
    p_title VARCHAR(30),
    p_type label,
    p_time_range VARCHAR(20),
    p_description VARCHAR(666)
)
LANGUAGE plpgsql AS $$
BEGIN
    INSERT INTO gakureki(email, title, type, time_range, description)
    VALUES (P_email, p_title, p_type, p_time_range, p_description, p_email);
END;
$$;

CREATE OR REPLACE PROCEDURE delete_jobsk_gakureki(
    p_id INTEGER
)
LANGUAGE plpgsql AS $$
BEGIN
    DELETE FROM gakureki WHERE id = p_id;
END;
$$;
/*Function 6: */

-- ChatGPT's Ideas about Funcs, Procs and Triggers: 
/*  create_candidate_profile(): create a new candidate profile, which would involve inserting their personal information (name, contact details, etc.)

    add_candidate_skills(): This procedure would allow an agent to add skills to a candidate's profile by updating the skill table.

    search_jobs(): This function could search for jobs based on certain criteria, such as location, industry, and required skills. Return a list of matching postings.

    apply_to_job(): This procedure would allow a candidate to apply to a job, which would involve creating a new application record in the applications table.

    update_application_status(): This procedure would update the status of a candidate's application based on feedback from the employer.

    generate_reports(): This function could generate reports on various metrics, such as the number of candidates placed, the most popular job categories, and the success rate of applications.

    update_total_apply()
    
    update_email (avoid violating key rules!)
    -- Triggers
    New candidate registration: Trigger an action when a new candidate registers on the platform, so their details can be added to the database and made available for job postings.

    New job posting: Trigger an action when a new job is posted, so that candidates with relevant skills can be notified of the opportunity.

    Application received: Trigger an action when a candidate applies for a job, so that their details can be added to the database and the employer can be notified of the application.

    Shortlisted for interview: Trigger an action when a candidate is shortlisted for an interview, so that they can be contacted and the interview can be scheduled.

    Job offer made: Trigger an action when a job offer is made to a candidate, so that the candidate can be contacted and the details of the job offer can be recorded in the database.

    Job filled: Trigger an action when a job is filled, so that the job listing can be removed from the platform and all relevant parties can be notified.

    job_application_closed: when close time comes
        CREATE OR REPLACE FUNCTION update_status_to_closed()
          RETURNS TRIGGER AS
        $$
        BEGIN
          IF NEW."Application Close" < CURRENT_DATE THEN
            NEW."Status" := 'Closed';
          END IF;

          RETURN NEW;
        END;
        $$
        LANGUAGE plpgsql;

        CREATE TRIGGER trg_update_status_to_closed
        BEFORE INSERT OR UPDATE ON your_table_name
        FOR EACH ROW
        EXECUTE FUNCTION update_status_to_closed();
    
*/
/***************************************************************************
 **************************** CREATE VIEWS *********************************
 ***************************************************************************/
CREATE OR REPLACE VIEW v_joblist AS
SELECT email AS "Email", industry AS "Industry", job_title AS "Job Title", salary_demand AS "Salary Demand", location AS "Location", close_at AS "Application Close", status AS "Status" FROM joblist;

CREATE OR REPLACE VIEW v_jobsk AS SELECT fullname AS "Fullname", email AS "Email", industry AS "Industry" FROM jobseeker WHERE isprivate = 'Public';

CREATE OR REPLACE VIEW v_emplr AS SELECT empname AS "Corporation", industry AS "Industry", website AS "Website" FROM employer WHERE empname IS NOT NULL AND industry IS NOT NULL;


/* Dump values here
 *
 */
SELECT add_user('nguyenhuuduc2109@gmail.com', '20210192');
/*INSERT INTO jobseeker VALUES
('Yuduke Nguyen', '2003-09-21', 'Male', 'nguyenhuuduc2109@gmail.com', '+84', 'Phuong Mai Street', 'Outstanding Antagonist', 'ApplicationOnly');
INSERT INTO gakureki VALUES
(1, 'nguyenhuuduc2109@gmail.com', 'Ky Su Viet Nhat', 'Degree', '2021-2025', 'Ky Su IT DHBKHN');
INSERT INTO skill VALUES
(1, 'nguyenhuuduc2109@gmail.com', 'Ky Nang Lua Ga (Top 1 Server)', 'Broker Uy tin hang dau');*/

SELECT add_user('thichnhathoc704@gmail.com', 'Lucky0192');
SELECT add_user('daomobutky2003@gmail.com', 'daomobutky2003');
SELECT add_user('nguyenhuuduc2109@gmail.com', '20210192');

SELECT add_emp('hr@sun.jp', 'sun1sen');
SELECT add_emp('sreholding@yahoo.jp', 'sonyretail');

INSERT INTO employer VALUES ('Sun* Asterisk', 'Tokyo, Japan', 'hr@sun.jp', '+81', 'sun-asterisk.jp', 'Education','1sen price in Tokyo Stock');
INSERT INTO employer VALUES ('SRE Holdings', 'Tokyo, Japan', 'sreholding@yahoo.jp', '+81', 'sre-holdings.jp', 'Real Estate', 'Top 1 2021 Tokyo Stock');

CALL add_job_advertisement('hr@sun.jp', 'Cong Nghe Thong Tin', 'Fullstack Dev', 'Overtime 24/7', 'Negotiable', '3 years of service', 'Dai Hoc', 'Da Nang', '2023-08-01');
CALL add_job_advertisement('sreholding@yahoo.jp', 'Cong Nghe Thong Tin', 'Embedded Dev', 'Lorem ipsum', 'More than 50M', 'No required', 'Dai Hoc', 'Tokyo', '2023-09-21');

