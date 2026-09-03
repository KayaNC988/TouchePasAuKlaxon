<?php

use PHPUnit\Framework\TestCase;

class TrajetTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        require __DIR__ . '/../config/database.php';

        $this->pdo = $pdo;
        $this->pdo->beginTransaction();
    }

    protected function tearDown(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }

    public function testCreationTrajetEnBase(): void
    {
        $agences = $this->pdo
            ->query('SELECT id FROM agences ORDER BY id ASC LIMIT 2')
            ->fetchAll(PDO::FETCH_COLUMN);

        $auteurId = $this->pdo
            ->query('SELECT id FROM users ORDER BY id ASC LIMIT 1')
            ->fetchColumn();

        $this->assertCount(2, $agences);
        $this->assertNotFalse($auteurId);

        $stmt = $this->pdo->prepare(
            'INSERT INTO trajets (
                agence_depart_id,
                agence_arrivee_id,
                depart_at,
                arrivee_at,
                places_total,
                places_disponibles,
                auteur_id
            ) VALUES (
                :agence_depart_id,
                :agence_arrivee_id,
                :depart_at,
                :arrivee_at,
                :places_total,
                :places_disponibles,
                :auteur_id
            )'
        );

        $stmt->execute([
            'agence_depart_id' => $agences[0],
            'agence_arrivee_id' => $agences[1],
            'depart_at' => '2030-01-10 08:00:00',
            'arrivee_at' => '2030-01-10 12:00:00',
            'places_total' => 4,
            'places_disponibles' => 4,
            'auteur_id' => $auteurId,
        ]);

        $trajetId = (int) $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare(
            'SELECT * FROM trajets WHERE id = :id'
        );

        $stmt->execute([
            'id' => $trajetId,
        ]);

        $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($trajet);
        $this->assertSame(4, (int) $trajet['places_total']);
        $this->assertSame(4, (int) $trajet['places_disponibles']);
    }

    public function testCreationAgenceEnBase(): void
{
    $ville = 'Ville Test PHPUnit';

    $stmt = $this->pdo->prepare(
        'INSERT INTO agences (ville) VALUES (:ville)'
    );

    $stmt->execute([
        'ville' => $ville,
    ]);

    $agenceId = (int) $this->pdo->lastInsertId();

    $stmt = $this->pdo->prepare(
        'SELECT * FROM agences WHERE id = :id'
    );

    $stmt->execute([
        'id' => $agenceId,
    ]);

    $agence = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotFalse($agence);
    $this->assertSame($ville, $agence['ville']);
}

public function testModificationTrajetEnBase(): void
{
    $trajetId = $this->pdo
        ->query('SELECT id FROM trajets ORDER BY id ASC LIMIT 1')
        ->fetchColumn();

    $this->assertNotFalse($trajetId);

    $stmt = $this->pdo->prepare(
        'UPDATE trajets
         SET places_total = :places_total,
             places_disponibles = :places_disponibles
         WHERE id = :id'
    );

    $stmt->execute([
        'places_total' => 6,
        'places_disponibles' => 6,
        'id' => $trajetId,
    ]);

    $stmt = $this->pdo->prepare(
        'SELECT places_total, places_disponibles
         FROM trajets
         WHERE id = :id'
    );

    $stmt->execute([
        'id' => $trajetId,
    ]);

    $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotFalse($trajet);
    $this->assertSame(6, (int) $trajet['places_total']);
    $this->assertSame(6, (int) $trajet['places_disponibles']);
}

public function testSuppressionTrajetEnBase(): void
{
    $trajetId = $this->pdo
        ->query('SELECT id FROM trajets ORDER BY id ASC LIMIT 1')
        ->fetchColumn();

    $this->assertNotFalse($trajetId);

    $stmt = $this->pdo->prepare(
        'DELETE FROM trajets WHERE id = :id'
    );

    $stmt->execute([
        'id' => $trajetId,
    ]);

    $stmt = $this->pdo->prepare(
        'SELECT id FROM trajets WHERE id = :id'
    );

    $stmt->execute([
        'id' => $trajetId,
    ]);

    $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertFalse($trajet);
}

}