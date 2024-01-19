<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119195128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quantite_ingredient (id INT AUTO_INCREMENT NOT NULL, id_ingredient_id INT DEFAULT NULL, recette_id INT DEFAULT NULL, quantite DOUBLE PRECISION NOT NULL, unite VARCHAR(255) NOT NULL, INDEX IDX_B24201872D1731E9 (id_ingredient_id), INDEX IDX_B242018789312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, conseil VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quantite_ingredient ADD CONSTRAINT FK_B24201872D1731E9 FOREIGN KEY (id_ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE quantite_ingredient ADD CONSTRAINT FK_B242018789312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite_ingredient DROP FOREIGN KEY FK_B24201872D1731E9');
        $this->addSql('ALTER TABLE quantite_ingredient DROP FOREIGN KEY FK_B242018789312FE9');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE quantite_ingredient');
        $this->addSql('DROP TABLE recette');
    }
}
