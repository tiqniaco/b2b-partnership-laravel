<?php

$query = "
CREATE OR REPLACE VIEW client_job_application_view AS
SELECT 
    job_applications.id AS job_application_id,
    job_applications.client_id,
    job_applications.years_of_experience,
    job_applications.cover_letter,
    job_applications.resume,
    job_applications.skills,
    job_applications.available_to_start_date,
    job_applications.expected_salary,
    job_applications.why_ideal_candidate,
    job_applications.status AS application_status,
    jobs.id AS job_id,
    jobs.title AS job_title,
    jobs.description AS job_description,
    jobs.skills AS job_skills,
    jobs.contract_type AS job_contract_type,
    jobs.expiry_date AS job_expiration_date,
    jobs.gender AS job_gender,
    jobs.salary AS job_salary,
    jobs.status AS job_status,
    p.id AS provider_user_id,
    p.name AS provider_name,
    p.email AS provider_email,
    p.country_code AS provider_country_code,
    p.phone AS provider_phone,
    p.image AS provider_image,
    c.id AS client_user_id, 
    c.name AS client_name,
    c.email AS client_email,    
    c.country_code AS client_country_code,  
    c.phone AS client_phone,
    c.image AS client_image,
    providers.rating AS provider_rating,
    job_applications.created_at,
    job_applications.updated_at
FROM 
    job_applications
JOIN 
    jobs ON job_applications.job_id = jobs.id
JOIN
    providers ON jobs.employer_id = providers.id
JOIN 
    users as p ON providers.user_id = p.id
JOIN
    clients ON job_applications.client_id = clients.id
JOIN
    users as c ON clients.user_id = c.id;

";