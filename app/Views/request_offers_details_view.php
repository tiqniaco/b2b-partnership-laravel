<?php

$query = "
CREATE VIEW request_offers_details_view AS
SELECT 
	request_offers.id AS request_offer_id,
    request_offers.provider_id,
    request_offers.request_service_id,
    request_offers.offer_description,
    request_offers.status AS request_offer_status,
    request_offers.price AS request_offer_price,
    request_offers.created_at AS request_offer_created_at,
    request_offers.updated_at AS request_offer_updated_at,
    users.id AS provider_user_id,
    users.name AS provider_name,
    users.email AS provider_email,
    users.country_code AS provider_country_code,
    users.phone AS provider_phone,
    users.image AS provider_image,
    providers.commercial_register AS provider_commercial_register,
    providers.tax_card AS provider_tax_card,
    providers.bio AS provider_bio,
    providers.rating AS provider_rating,
    provider_types.name_ar AS provider_type_name_ar,
    provider_types.name_en AS provider_type_name_en,
    specializations.id AS provider_specialization_id,
    specializations.name_ar AS provider_specialization_name_ar,
    specializations.name_en AS provider_specialization_name_en,
    sub_specializations.id AS provider_sub_specialization_id,
    sub_specializations.name_ar AS provider_sub_specialization_name_ar,
    sub_specializations.name_en AS provider_sub_specialization_name_en,
    countries.id AS provider_country_id,
    countries.name_ar AS provider_country_name_ar,
    countries.name_en AS provider_country_name_en,
    governments.id AS provider_government_id,
    governments.name_ar AS provider_government_name_ar,
    governments.name_en AS provider_government_name_en,
    provider_contacts.phone AS provider_contact_phone,
    provider_contacts.email AS provider_contact_email,
    provider_contacts.whatsapp AS provider_contact_whatsapp,
    provider_contacts.telegram AS provider_contact_telegram,
    provider_contacts.instagram AS provider_contact_instagram,
    provider_contacts.facebook AS provider_contact_facebook,
    provider_contacts.linkedin AS provider_contact_linkedin,
    provider_contacts.website AS provider_contact_website,
    providers.created_at AS provider_created_at,
    providers.updated_at AS provider_updated_at
FROM 
    request_offers
JOIN 
    providers ON request_offers.provider_id = providers.id
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