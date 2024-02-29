<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228123507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE homework (id INT AUTO_INCREMENT NOT NULL, student_class_id INT NOT NULL, user_id INT NOT NULL, description LONGTEXT NOT NULL, submission_deadline DATE NOT NULL, posted_date DATE NOT NULL, INDEX IDX_8C600B4E598B478B (student_class_id), INDEX IDX_8C600B4EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_class (id INT AUTO_INCREMENT NOT NULL, class_title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE submission (id INT AUTO_INCREMENT NOT NULL, homework_id INT NOT NULL, user_id INT NOT NULL, uploaded_file_id INT NOT NULL, date_submitted DATE NOT NULL, remarks LONGTEXT DEFAULT NULL, INDEX IDX_DB055AF3B203DDE5 (homework_id), INDEX IDX_DB055AF3A76ED395 (user_id), INDEX IDX_DB055AF3276973A0 (uploaded_file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uploaded_file (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, file_title VARCHAR(255) NOT NULL, original_filename VARCHAR(255) NOT NULL, date_uploaded DATE NOT NULL, INDEX IDX_B40DF75DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_class (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, student_class_id INT NOT NULL, INDEX IDX_F89E2C7A76ED395 (user_id), INDEX IDX_F89E2C7598B478B (student_class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE homework ADD CONSTRAINT FK_8C600B4E598B478B FOREIGN KEY (student_class_id) REFERENCES student_class (id)');
        $this->addSql('ALTER TABLE homework ADD CONSTRAINT FK_8C600B4EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE submission ADD CONSTRAINT FK_DB055AF3B203DDE5 FOREIGN KEY (homework_id) REFERENCES homework (id)');
        $this->addSql('ALTER TABLE submission ADD CONSTRAINT FK_DB055AF3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE submission ADD CONSTRAINT FK_DB055AF3276973A0 FOREIGN KEY (uploaded_file_id) REFERENCES uploaded_file (id)');
        $this->addSql('ALTER TABLE uploaded_file ADD CONSTRAINT FK_B40DF75DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_class ADD CONSTRAINT FK_F89E2C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_class ADD CONSTRAINT FK_F89E2C7598B478B FOREIGN KEY (student_class_id) REFERENCES student_class (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE homework DROP FOREIGN KEY FK_8C600B4E598B478B');
        $this->addSql('ALTER TABLE homework DROP FOREIGN KEY FK_8C600B4EA76ED395');
        $this->addSql('ALTER TABLE submission DROP FOREIGN KEY FK_DB055AF3B203DDE5');
        $this->addSql('ALTER TABLE submission DROP FOREIGN KEY FK_DB055AF3A76ED395');
        $this->addSql('ALTER TABLE submission DROP FOREIGN KEY FK_DB055AF3276973A0');
        $this->addSql('ALTER TABLE uploaded_file DROP FOREIGN KEY FK_B40DF75DA76ED395');
        $this->addSql('ALTER TABLE user_class DROP FOREIGN KEY FK_F89E2C7A76ED395');
        $this->addSql('ALTER TABLE user_class DROP FOREIGN KEY FK_F89E2C7598B478B');
        $this->addSql('DROP TABLE homework');
        $this->addSql('DROP TABLE student_class');
        $this->addSql('DROP TABLE submission');
        $this->addSql('DROP TABLE uploaded_file');
        $this->addSql('DROP TABLE user_class');
    }
}
