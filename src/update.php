<?php
// Connect to the database
require_once('db_conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sujet = $_POST['sujet'];
    $date = $_POST['date'];
    $niveau = $_POST['niveau'];
    $parcours = $_POST['parcours'];
    $organisme = $_POST['organisme'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $dumas = $_POST['dumas'];
    $archives = isset($_POST['archives']) ? 1 : 0;
    $effectue = isset($_POST['effectue']) ? 1 : 0;

    try {
        // 使用 PDO 进行更新操作
        $stmt = $db->prepare("UPDATE offres SET sujet = :sujet, date = :date, niveau = :niveau, parcours = :parcours, organisme = :organisme, contact = :contact, email = :email, dumas = :dumas, archives = :archives, effectue = :effectue WHERE id = :id");
        $stmt->bindParam(':sujet', $sujet);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':niveau', $niveau);
        $stmt->bindParam(':parcours', $parcours);
        $stmt->bindParam(':organisme', $organisme);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dumas', $dumas);
        $stmt->bindParam(':archives', $archives);
        $stmt->bindParam(':effectue', $effectue);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // 成功时返回JSON格式
            echo json_encode(["status" => "success", "message" => "Mise à jour réussie !"]);
        } else {
            // 失败时返回错误消息
            echo json_encode(["status" => "error", "message" => "Erreur lors de la mise à jour."]);
        }
    } catch (PDOException $e) {
        // 捕获异常并返回错误信息
        echo json_encode(["status" => "error", "message" => "Erreur : " . $e->getMessage()]);
    }
}
?>
