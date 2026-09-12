-- Database users for the absence management app.
-- Two roles, following the least-privilege principle:
--   - one admin who can read and write everything
--   - one reader who can only consult (public statistics)

-- Admin account: full read/write access
CREATE USER IF NOT EXISTS 'absence_admin'@'localhost'
    IDENTIFIED BY 'AdminP@ss2026';
GRANT SELECT, INSERT, UPDATE, DELETE ON ecf2_lucas.*
    TO 'absence_admin'@'localhost';

-- Reader account: read-only, used for public consultation
CREATE USER IF NOT EXISTS 'absence_reader'@'localhost'
    IDENTIFIED BY 'ReaderP@ss2026';
GRANT SELECT ON ecf2_lucas.*
    TO 'absence_reader'@'localhost';

-- Apply the new privileges right away
FLUSH PRIVILEGES;