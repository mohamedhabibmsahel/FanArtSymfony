<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423225746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement CHANGE Date_debut Date_debut VARCHAR(30) DEFAULT \'NULL\' NOT NULL, CHANGE Date_Fin Date_Fin VARCHAR(30) DEFAULT \'NULL\' NOT NULL, CHANGE image image VARCHAR(200) DEFAULT \'NULL\' NOT NULL');
        $this->addSql('ALTER TABLE participant CHANGE Nbr_reservation Nbr_reservation INT DEFAULT NULL, CHANGE Paiement Paiement INT DEFAULT NULL, CHANGE Date_paiement Date_paiement DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY reset_password_request_ibfk_1');
        $this->addSql('ALTER TABLE reset_password_request CHANGE requested_At requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE expires_At expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP INDEX user_id ON reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT reset_password_request_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE salle CHANGE disponibilite disponibilite VARCHAR(50) DEFAULT \'NULL\', CHANGE date date VARCHAR(50) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(30) NOT NULL, CHANGE prenom prenom VARCHAR(30) NOT NULL, CHANGE mdp mdp VARCHAR(300) NOT NULL, CHANGE numtel numtel INT NOT NULL, CHANGE photo photo VARCHAR(1000) NOT NULL, CHANGE type type VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement CHANGE Date_debut Date_debut VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE Date_Fin Date_Fin VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE image image VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE participant CHANGE Nbr_reservation Nbr_reservation INT DEFAULT NULL, CHANGE Paiement Paiement INT DEFAULT NULL, CHANGE Date_paiement Date_paiement DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE reset_password_request CHANGE requested_at requested_At DATETIME NOT NULL, CHANGE expires_at expires_At DATETIME NOT NULL');
        $this->addSql('DROP INDEX idx_7ce748aa76ed395 ON reset_password_request');
        $this->addSql('CREATE INDEX user_id ON reset_password_request (user_id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE salle CHANGE disponibilite disponibilite VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE date date VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE prenom prenom VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE mdp mdp VARCHAR(300) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE numtel numtel INT DEFAULT NULL, CHANGE photo photo VARCHAR(1000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE type type VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`');
    }
}
