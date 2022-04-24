<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422132243 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, prenom VARCHAR(25) NOT NULL, tache VARCHAR(25) NOT NULL, disponible VARCHAR(25) DEFAULT \'\'\'dispo\'\'\' NOT NULL, age INT NOT NULL, mobile INT NOT NULL, salaire DOUBLE PRECISION NOT NULL, num_carte VARCHAR(25) NOT NULL, id_salle INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participant ADD id INT AUTO_INCREMENT NOT NULL, CHANGE Nbr_reservation Nbr_reservation INT DEFAULT NULL, CHANGE Paiement Paiement INT DEFAULT NULL, CHANGE Date_paiement Date_paiement DATE DEFAULT \'NULL\', ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE salle ADD disponibilite VARCHAR(50) DEFAULT \'NULL\', ADD date VARCHAR(50) DEFAULT \'NULL\', DROP image');
        $this->addSql('ALTER TABLE user CHANGE photo photo VARCHAR(1000) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE participant MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE participant DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE participant DROP id, CHANGE Nbr_reservation Nbr_reservation INT DEFAULT NULL, CHANGE Paiement Paiement INT DEFAULT NULL, CHANGE Date_paiement Date_paiement DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE salle ADD image VARCHAR(200) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, DROP disponibilite, DROP date');
        $this->addSql('ALTER TABLE user CHANGE photo photo VARCHAR(1000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
    }
}
