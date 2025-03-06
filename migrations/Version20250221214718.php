<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221214718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE money_movement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parameter_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pricelist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE stock_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE account (id INT NOT NULL, comment TEXT NOT NULL, name VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, comment VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, phone1 VARCHAR(255) NOT NULL, phone2 VARCHAR(255) DEFAULT NULL, phone3 VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, discount DOUBLE PRECISION NOT NULL, history TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, comment VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, phone1 VARCHAR(255) NOT NULL, phone2 VARCHAR(255) NOT NULL, phone3 VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE item (id INT NOT NULL, model_id INT NOT NULL, stock_id INT NOT NULL, comment VARCHAR(255) NOT NULL, photo1 VARCHAR(255) NOT NULL, photo2 VARCHAR(255) NOT NULL, photo3 VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F1B251E7975B7E7 ON item (model_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251EDCD6110 ON item (stock_id)');
        $this->addSql('CREATE TABLE items_to_orders (item_id INT NOT NULL, order_id INT NOT NULL, PRIMARY KEY(item_id, order_id))');
        $this->addSql('CREATE INDEX IDX_BF566574126F525E ON items_to_orders (item_id)');
        $this->addSql('CREATE INDEX IDX_BF5665748D9F6D38 ON items_to_orders (order_id)');
        $this->addSql('CREATE TABLE model (id INT NOT NULL, comment VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, photo1 VARCHAR(255) NOT NULL, photo2 VARCHAR(255) NOT NULL, photo3 VARCHAR(255) NOT NULL, video1 VARCHAR(255) NOT NULL, video2 VARCHAR(255) NOT NULL, video3 VARCHAR(255) NOT NULL, description1 TEXT NOT NULL, description2 TEXT NOT NULL, description3 TEXT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE models_to_orders (model_id INT NOT NULL, order_id INT NOT NULL, PRIMARY KEY(model_id, order_id))');
        $this->addSql('CREATE INDEX IDX_6BD846E97975B7E7 ON models_to_orders (model_id)');
        $this->addSql('CREATE INDEX IDX_6BD846E98D9F6D38 ON models_to_orders (order_id)');
        $this->addSql('CREATE TABLE money_movement (id INT NOT NULL, from_account_id INT NOT NULL, to_account_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, movement_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, comment VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_15B766D9B0CF99BD ON money_movement (from_account_id)');
        $this->addSql('CREATE INDEX IDX_15B766D9BC58BDC7 ON money_movement (to_account_id)');
        $this->addSql('CREATE TABLE movement (id INT NOT NULL, from_stock_id INT NOT NULL, to_stock_id INT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, comment VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F4DD95F74B22818A ON movement (from_stock_id)');
        $this->addSql('CREATE INDEX IDX_F4DD95F7C094FFBE ON movement (to_stock_id)');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, status_id INT NOT NULL, client_id INT NOT NULL, giver_id INT NOT NULL, taker_id INT NOT NULL, give_stock_id INT NOT NULL, take_stock_id INT NOT NULL, comment VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, begin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivery_address_to VARCHAR(255) NOT NULL, delivery_address_from VARCHAR(255) NOT NULL, delivery_price DOUBLE PRECISION NOT NULL, total_amount DOUBLE PRECISION NOT NULL, total_deposit DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993986BF700BD ON "order" (status_id)');
        $this->addSql('CREATE INDEX IDX_F529939819EB6921 ON "order" (client_id)');
        $this->addSql('CREATE INDEX IDX_F529939875BD1D29 ON "order" (giver_id)');
        $this->addSql('CREATE INDEX IDX_F5299398B2E74C3 ON "order" (taker_id)');
        $this->addSql('CREATE INDEX IDX_F52993982D52AB47 ON "order" (give_stock_id)');
        $this->addSql('CREATE INDEX IDX_F529939847F19E61 ON "order" (take_stock_id)');
        $this->addSql('CREATE TABLE parameter (id INT NOT NULL, comment VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pricelist (id INT NOT NULL, model_id INT NOT NULL, price_for_period DOUBLE PRECISION NOT NULL, deposit_for_period DOUBLE PRECISION NOT NULL, full_price_for_period DOUBLE PRECISION NOT NULL, period_min DOUBLE PRECISION NOT NULL, period_max DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5CCFEA6D7975B7E7 ON pricelist (model_id)');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE stock (id INT NOT NULL, address VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, comment VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items_to_orders ADD CONSTRAINT FK_BF566574126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items_to_orders ADD CONSTRAINT FK_BF5665748D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE models_to_orders ADD CONSTRAINT FK_6BD846E97975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE models_to_orders ADD CONSTRAINT FK_6BD846E98D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE money_movement ADD CONSTRAINT FK_15B766D9B0CF99BD FOREIGN KEY (from_account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE money_movement ADD CONSTRAINT FK_15B766D9BC58BDC7 FOREIGN KEY (to_account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F74B22818A FOREIGN KEY (from_stock_id) REFERENCES stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7C094FFBE FOREIGN KEY (to_stock_id) REFERENCES stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F529939875BD1D29 FOREIGN KEY (giver_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398B2E74C3 FOREIGN KEY (taker_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993982D52AB47 FOREIGN KEY (give_stock_id) REFERENCES stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F529939847F19E61 FOREIGN KEY (take_stock_id) REFERENCES stock (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pricelist ADD CONSTRAINT FK_5CCFEA6D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE account_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE money_movement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE parameter_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pricelist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE stock_id_seq CASCADE');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251E7975B7E7');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251EDCD6110');
        $this->addSql('ALTER TABLE items_to_orders DROP CONSTRAINT FK_BF566574126F525E');
        $this->addSql('ALTER TABLE items_to_orders DROP CONSTRAINT FK_BF5665748D9F6D38');
        $this->addSql('ALTER TABLE models_to_orders DROP CONSTRAINT FK_6BD846E97975B7E7');
        $this->addSql('ALTER TABLE models_to_orders DROP CONSTRAINT FK_6BD846E98D9F6D38');
        $this->addSql('ALTER TABLE money_movement DROP CONSTRAINT FK_15B766D9B0CF99BD');
        $this->addSql('ALTER TABLE money_movement DROP CONSTRAINT FK_15B766D9BC58BDC7');
        $this->addSql('ALTER TABLE movement DROP CONSTRAINT FK_F4DD95F74B22818A');
        $this->addSql('ALTER TABLE movement DROP CONSTRAINT FK_F4DD95F7C094FFBE');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993986BF700BD');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F529939819EB6921');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F529939875BD1D29');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398B2E74C3');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993982D52AB47');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F529939847F19E61');
        $this->addSql('ALTER TABLE pricelist DROP CONSTRAINT FK_5CCFEA6D7975B7E7');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE items_to_orders');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE models_to_orders');
        $this->addSql('DROP TABLE money_movement');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE parameter');
        $this->addSql('DROP TABLE pricelist');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE stock');
    }
}
