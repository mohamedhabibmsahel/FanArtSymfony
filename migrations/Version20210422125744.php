<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422125744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(25) NOT NULL, prenom VARCHAR(25) NOT NULL, tache VARCHAR(25) NOT NULL, disponible VARCHAR(25) DEFAULT \'\'\'dispo\'\'\' NOT NULL, age INT NOT NULL, mobile INT NOT NULL, salaire DOUBLE PRECISION NOT NULL, num_carte VARCHAR(25) NOT NULL, id_salle INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id_user INT DEFAULT NULL, Id_evenement INT AUTO_INCREMENT NOT NULL, Titre VARCHAR(30) NOT NULL, Description VARCHAR(500) NOT NULL, Locall VARCHAR(30) NOT NULL, Date_debut VARCHAR(30) DEFAULT \'NULL\' NOT NULL, Date_Fin VARCHAR(30) DEFAULT \'NULL\' NOT NULL, Nombre_place INT NOT NULL, Prix INT NOT NULL, image VARCHAR(200) DEFAULT \'NULL\' NOT NULL, INDEX id_user (id_user), PRIMARY KEY(Id_evenement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id_panier INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, validite VARCHAR(20) NOT NULL, INDEX id_user (id_user), PRIMARY KEY(id_panier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_elem (id_panier INT NOT NULL, id_produit INT NOT NULL, quantite INT NOT NULL, INDEX id_panier (id_panier), INDEX FK_id_produit (id_produit), PRIMARY KEY(id_panier, id_produit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, Id_participant INT NOT NULL, Id_evenement INT NOT NULL, Nbr_reservation INT DEFAULT NULL, Paiement INT DEFAULT NULL, Date_paiement DATE DEFAULT \'NULL\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id_produit INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) NOT NULL, description VARCHAR(200) NOT NULL, image VARCHAR(200) NOT NULL, id_user INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX id_user (id_user), PRIMARY KEY(id_produit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recevent (receid INT AUTO_INCREMENT NOT NULL, nomevent VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, reclevent TEXT NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(receid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recprod (recpid INT AUTO_INCREMENT NOT NULL, nomprod VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, reclprod TEXT NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(recpid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (idsalle INT AUTO_INCREMENT NOT NULL, numsalle VARCHAR(50) NOT NULL, nbreplace VARCHAR(50) NOT NULL, description VARCHAR(200) NOT NULL, disponibilite VARCHAR(50) DEFAULT \'NULL\', date VARCHAR(50) DEFAULT \'NULL\', PRIMARY KEY(idsalle)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, mdp VARCHAR(300) NOT NULL, email VARCHAR(255) NOT NULL, numtel INT NOT NULL, photo VARCHAR(1000) NOT NULL, type VARCHAR(20) NOT NULL, UNIQUE INDEX email (email), UNIQUE INDEX numtel (numtel), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E6B3CA4B');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_elem');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE recevent');
        $this->addSql('DROP TABLE recprod');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE user');
    }
}
