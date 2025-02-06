<?php

$query = "
CREATE VIEW provider_details AS
SELECT 
    users.id AS user_id,
    users.name AS name,
    users.email AS email,
    users.country_code AS country_code,
    users.phone AS phone,
    users.image AS image,
    providers.id AS provider_id,
    providers.commercial_register AS commercial_register,
    providers.tax_card AS tax_card,
    providers.bio AS bio,
    providers.rating AS rating,
    provider_types.name_ar AS provider_type_name_ar,
    provider_types.name_en AS provider_type_name_en,
    specializations.id AS specialization_id,
    specializations.name_ar AS specialization_name_ar,
    specializations.name_en AS specialization_name_en,
    sub_specializations.id AS sub_specialization_id,
    sub_specializations.name_ar AS sub_specialization_name_ar,
    sub_specializations.name_en AS sub_specialization_name_en,
    countries.id AS country_id,
    countries.name_ar AS country_name_ar,
    countries.name_en AS country_name_en,
    governments.id AS government_id,
    governments.name_ar AS government_name_ar,
    governments.name_en AS government_name_en,
    provider_contacts.phone AS contact_phone,
    provider_contacts.email AS contact_email,
    provider_contacts.whatsapp AS contact_whatsapp,
    provider_contacts.telegram AS contact_telegram,
    provider_contacts.instagram AS contact_instagram,
    provider_contacts.facebook AS contact_facebook,
    provider_contacts.linkedin AS contact_linkedin,
    provider_contacts.website AS contact_website,
    providers.created_at AS created_at,
    providers.updated_at AS updated_at
FROM 
    providers
JOIN 
    users ON providers.user_id = users.id
JOIN 
    provider_types ON providers.provider_types_id = provider_types.id
JOIN 
    sub_specializations ON providers.sub_specialization_id = sub_specializations.id
JOIN 
    governments ON providers.governments_id = governments.id
JOIN 
    countries ON governments.country_id = countries.id
JOIN 
    specializations ON sub_specializations.parent_id = specializations.id
LEFT JOIN 
    provider_contacts ON providers.id = provider_contacts.provider_id;
";