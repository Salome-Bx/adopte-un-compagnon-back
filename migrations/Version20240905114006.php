<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240905114006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE behavior (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form (id INT AUTO_INCREMENT NOT NULL, pet_id INT NOT NULL, date_form DATE DEFAULT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, phone VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_5288FD4F966F7FB6 (pet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pet (id INT AUTO_INCREMENT NOT NULL, species_id INT NOT NULL, asso_id INT NOT NULL, name VARCHAR(255) NOT NULL, birthyear DATE NOT NULL, gender VARCHAR(255) NOT NULL, quick_description VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, get_along_cats TINYINT(1) NOT NULL, get_along_dogs TINYINT(1) NOT NULL, get_along_children TINYINT(1) NOT NULL, entry_date DATE NOT NULL, register_date DATE NOT NULL, update_date DATE DEFAULT NULL, sos TINYINT(1) NOT NULL, race VARCHAR(255) NOT NULL, categorised_dog VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_E4529B85B2A1D860 (species_id), INDEX IDX_E4529B85792C8628 (asso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pet_behavior (pet_id INT NOT NULL, behavior_id INT NOT NULL, INDEX IDX_72DCA97D966F7FB6 (pet_id), INDEX IDX_72DCA97D4C1CFD92 (behavior_id), PRIMARY KEY(pet_id, behavior_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, register_date DATE DEFAULT NULL, name_asso VARCHAR(255) DEFAULT NULL, siret VARCHAR(14) DEFAULT NULL, gdpr DATE DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85B2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85792C8628 FOREIGN KEY (asso_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE pet_behavior ADD CONSTRAINT FK_72DCA97D966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pet_behavior ADD CONSTRAINT FK_72DCA97D4C1CFD92 FOREIGN KEY (behavior_id) REFERENCES behavior (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4F966F7FB6');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B85B2A1D860');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B85792C8628');
        $this->addSql('ALTER TABLE pet_behavior DROP FOREIGN KEY FK_72DCA97D966F7FB6');
        $this->addSql('ALTER TABLE pet_behavior DROP FOREIGN KEY FK_72DCA97D4C1CFD92');
        $this->addSql('DROP TABLE behavior');
        $this->addSql('DROP TABLE form');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE pet_behavior');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP TABLE `user`');
    }
}
