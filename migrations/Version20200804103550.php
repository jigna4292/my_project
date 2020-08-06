<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200804103550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE software (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, platform_id INT NOT NULL, version DOUBLE PRECISION NOT NULL, download_path VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_77D068CF4584665A (product_id), INDEX IDX_77D068CFFFE6496F (platform_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CF4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CFFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE software');
    }
}
