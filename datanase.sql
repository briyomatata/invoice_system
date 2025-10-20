-- ===== Fix or create lpo_items table =====
CREATE TABLE IF NOT EXISTS lpo_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lpo_id INT,
  description VARCHAR(255),
  quantity INT,
  price DECIMAL(10,2),
  amount DECIMAL(10,2),
  FOREIGN KEY (lpo_id) REFERENCES lpos(id) ON DELETE CASCADE
);

-- Standardize column types if table already exists
ALTER TABLE lpo_items
  MODIFY COLUMN description VARCHAR(255),
  MODIFY COLUMN quantity INT,
  MODIFY COLUMN price DECIMAL(10,2),
  MODIFY COLUMN amount DECIMAL(10,2);




  -- ===== Fix or create lpos table =====
CREATE TABLE IF NOT EXISTS lpos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_name VARCHAR(255),
  supplier_email VARCHAR(255),
  subtotal DECIMAL(10,2),
  vat DECIMAL(10,2),
  total DECIMAL(10,2),
  due_date DATE,
  status VARCHAR(50) DEFAULT 'PENDING',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Clean old redundant columns if they exist
ALTER TABLE lpos
  DROP COLUMN IF EXISTS description,
  DROP COLUMN IF EXISTS quantity,
  DROP COLUMN IF EXISTS price;





================================================================================

-- ===== Fix structure of quotations table =====
ALTER TABLE quotations
  DROP COLUMN IF EXISTS description,
  DROP COLUMN IF EXISTS quantity,
  DROP COLUMN IF EXISTS price;

ALTER TABLE quotations
  ADD COLUMN IF NOT EXISTS subtotal DECIMAL(10,2) AFTER client_email,
  ADD COLUMN IF NOT EXISTS vat DECIMAL(10,2) AFTER subtotal,
  ADD COLUMN IF NOT EXISTS total DECIMAL(10,2) AFTER vat,
  ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'PENDING' AFTER total,
  ADD COLUMN IF NOT EXISTS created_at DATETIME DEFAULT CURRENT_TIMESTAMP AFTER status;



-- ===== Fix structure of quotation_items table =====
ALTER TABLE quotation_items
  MODIFY COLUMN description VARCHAR(255),
  MODIFY COLUMN quantity INT,
  MODIFY COLUMN price DECIMAL(10,2),
  MODIFY COLUMN amount DECIMAL(10,2);

-- Ensure foreign key link to quotations table
ALTER TABLE quotation_items
  ADD CONSTRAINT fk_quotation
  FOREIGN KEY (quotation_id) REFERENCES quotations(id)
  ON DELETE CASCADE;







=======================================================================================


-- ===== Rebuild invoices table =====
ALTER TABLE invoices
  DROP COLUMN IF EXISTS description,
  DROP COLUMN IF EXISTS quantity,
  DROP COLUMN IF EXISTS price;

ALTER TABLE invoices
  ADD COLUMN IF NOT EXISTS subtotal DECIMAL(10,2) AFTER client_email,
  ADD COLUMN IF NOT EXISTS vat DECIMAL(10,2) AFTER subtotal,
  ADD COLUMN IF NOT EXISTS total DECIMAL(10,2) AFTER vat,
  ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'UNPAID' AFTER total,
  ADD COLUMN IF NOT EXISTS created_at DATETIME DEFAULT CURRENT_TIMESTAMP AFTER status;


-- ===== Rebuild invoice_items table =====
ALTER TABLE invoice_items
  MODIFY COLUMN description VARCHAR(255),
  MODIFY COLUMN quantity INT,
  MODIFY COLUMN price DECIMAL(10,2),
  MODIFY COLUMN amount DECIMAL(10,2);

-- Make sure there's a proper relationship between invoices and invoice_items
ALTER TABLE invoice_items
  ADD CONSTRAINT fk_invoice
  FOREIGN KEY (invoice_id) REFERENCES invoices(id)
  ON DELETE CASCADE;
