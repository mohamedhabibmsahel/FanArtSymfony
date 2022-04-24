<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210414213219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, prenom VARCHAR(25) NOT NULL, tache VARCHAR(25) NOT NULL, disponible VARCHAR(25) DEFAULT \'\'\'dispo\'\'\' NOT NULL, age INT NOT NULL, mobile INT NOT NULL, salaire DOUBLE PRECISION NOT NULL, num_carte VARCHAR(25) NOT NULL, id_salle INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE local');
        $this->addSql('ALTER TABLE evenement CHANGE Date_debut Date_debut VARCHAR(30) DEFAULT \'NULL\' NOT NULL, CHANGE Date_Fin Date_Fin VARCHAR(30) DEFAULT \'NULL\' NOT NULL, CHANGE image image VARCHAR(200) DEFAULT \'NULL\' NOT NULL');
        $this->addSql('ALTER TABLE panier_elem ADD PRIMARY KEY (id_panier, id_produit)');
        $this->addSql('ALTER TABLE participant ADD id INT AUTO_INCREMENT NOT NULL, CHANGE Nbr_reservation Nbr_reservation INT DEFAULT NULL, CHANGE Paiement Paiement INT DEFAULT NULL, CHANGE Date_paiement Date_paiement DATE DEFAULT \'NULL\', ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE salle CHANGE disponibilite disponibilite VARCHAR(50) DEFAULT \'NULL\', CHANGE date date VARCHAR(50) DEFAULT \'NULL\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artiste (id_artiste INT NOT NULL, specialite VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_artiste (id_artiste)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE local (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE artiste ADD CONSTRAINT artiste_ibfk_1 FOREIGN KEY (id_artiste) REFERENCES user (id)');
        $this->addSql('DROP TABLE employe');
        $this->addSql('ALTER TABLE evenement CHANGE Date_debut Date_debut VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE Date_Fin Date_Fin VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE panier_elem DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE participant MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE participant DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE participant DROP id, CHANGE Nbr_reservation Nbr_reservation INT DEFAULT NULL, CHANGE Paiement Paiement INT DEFAULT NULL, CHANGE Date_paiement Date_paiement DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE salle CHANGE disponibilite disponibilite VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE date date VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
    }
}
