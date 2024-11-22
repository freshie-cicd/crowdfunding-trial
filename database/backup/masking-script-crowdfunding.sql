-- Update Bookings Table
UPDATE bookings
SET 
    booking_quantity = FLOOR(1 + (RAND() * 5));

-- Update Investor Bank Details Table
UPDATE investor_bank_details
SET 
    account_name   = CONCAT('Account_Holder_', id),
    account_number = LPAD(FLOOR(RAND() * 1000000000000), 13, '0');

-- Update Users Table
UPDATE users
SET 
    -- Mask Date of Birth
    date_of_birth = DATE_ADD('1970-01-01', INTERVAL FLOOR(RAND() * 15000) DAY),

    -- Mask User Name
    name = CONCAT('User_', id),

    -- Mask Email
    email = CONCAT(LEFT(MD5(id), 8), '@example.com'),

    -- Mask Phone Number
    phone = CONCAT(
        '+880',
        ELT(FLOOR(1 + (RAND() * 7)),
            '181', '182', '183', '185', '177', '187', '188'),
        LPAD(id, 7, '0')
    ),

    -- Mask National ID
    nid = LPAD(FLOOR(RAND() * 100000000000), 12, '0'),

    -- Mask Nominee Name
    nominee_name = CONCAT('Nominee_', id),

    -- Mask Nominee Phone
    nominee_phone = CONCAT(
        '+880',
        ELT(FLOOR(1 + (RAND() * 7)),
            '13', '14', '15', '16', '17', '18', '19'),
        LPAD(FLOOR(RAND() * 10000000), 7, '0')
    ),

    -- Mask Nominee National ID
    nominee_nid = LPAD(FLOOR(RAND() * 100000000000), 12, '0'),

    -- Mask Parent Names
    father_name = CONCAT('Father_', id),
    mother_name = CONCAT('Mother_', id),

    -- Mask Addresses
    permanent_address = CONCAT('Permanent Address ', id),
    present_address   = CONCAT('Present Address ', id),
    nominee_address   = CONCAT('Nominee Address ', id);

