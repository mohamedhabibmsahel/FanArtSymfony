<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422133049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evenement CHANGE Date_debut Date_debut VARCHAR(30) DEFAULT \'NULL\' NOT NULL, CHANGE Date_Fin Date_Fin VARCHAR(30) DEFAULT \'NULL\' NOT NULL, CHANGE image image VARCHAR(200) DEFAULT \'NULL\' NOT NULL');
        $this->addSql('ALTER TABLE participant CHANGE Nbr_reservation Nbr_reservation INT DEFAULT NULL, CHANGE Paiement Paiement INT DEFAULT NULL, CHANGE Date_paiement Date_paiement DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE salle CHANGE disponibilite disponibilite VARCHAR(50) DEFAULT \'NULL\', CHANGE date date VARCHAR(50) DEFAULT \'NULL\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE evenement CHANGE Date_debut Date_debut VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE Date_Fin Date_Fin VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE participant CHANGE Nbr_reservation Nbr_reservation INT DEFAULT NULL, CHANGE Paiement Paiement INT DEFAULT NULL, CHANGE Date_paiement Date_paiement DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE salle CHANGE disponibilite disponibilite VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE date date VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
    }
}
