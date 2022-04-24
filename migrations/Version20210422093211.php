<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422093211 extends AbstractMigration
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
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE local');
        $this->addSql('ALTER TABLE evenement CHANGE id_user id_user INT DEFAULT NULL, CHANGE Date_debut Date_debut VARCHAR(30) DEFAULT \'NULL\' NOT NULL, CHANGE Date_Fin Date_Fin VARCHAR(30) DEFAULT \'NULL\' NOT NULL, CHANGE image image VARCHAR(200) DEFAULT \'NULL\' NOT NULL');
        $this->addSql('ALTER TABLE panier_elem ADD PRIMARY KEY (id_panier, id_produit)');
        $this->addSql('ALTER TABLE participant ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE salle ADD disponibilite VARCHAR(50) DEFAULT \'NULL\', ADD date VARCHAR(50) DEFAULT \'NULL\', DROP image');
        $this->addSql('ALTER TABLE user CHANGE photo photo VARCHAR(1000) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artiste (id_artiste INT NOT NULL, specialite VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_artiste (id_artiste)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE local (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE artiste ADD CONSTRAINT artiste_ibfk_1 FOREIGN KEY (id_artiste) REFERENCES user (id)');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE evenement CHANGE id_user id_user INT DEFAULT NULL, CHANGE Date_debut Date_debut VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, CHANGE Date_Fin Date_Fin VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE panier_elem DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE participant MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE participant DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE participant DROP id');
        $this->addSql('ALTER TABLE salle ADD image VARCHAR(200) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, DROP disponibilite, DROP date');
        $this->addSql('ALTER TABLE user CHANGE photo photo VARCHAR(1000) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`');
    }
}
