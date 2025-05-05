<?php

$query = "
CREATE OR REPLACE VIEW request_offers_details_view AS
SELECT
    request_offers.id AS request_offer_id,
    request_offers.user_id,
    request_offers.request_service_id,
    request_offers.offer_description,
    request_offers.status AS request_offer_status,
    request_offers.price AS request_offer_price,
    request_offers.duration AS request_offer_duration,
    request_offers.created_at AS request_offer_created_at,
    request_offers.updated_at AS request_offer_updated_at,
    users.name AS user_name,
    users.email AS user_email,
    users.country_code AS user_country_code,
    users.phone AS user_phone,
    users.image AS user_image,
    users.role AS user_role,
    CASE
      WHEN users.role = 'client' THEN clients.id
      WHEN users.role = 'provider' THEN providers.id
      ELSE NULL
    END AS role_id
FROM
    request_offers
JOIN
    users ON request_offers.user_id = users.id
LEFT JOIN clients ON users.id = clients.user_id
LEFT JOIN providers ON users.id = providers.user_id;
";
