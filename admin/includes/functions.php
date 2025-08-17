<?php
// Nettoyage sortie HTML
function e($str){ return htmlspecialchars($str ?? "", ENT_QUOTES, 'UTF-8'); }

// Upload image dans /uploads (optionnel: sous-dossier)
function upload_image(array $file, string $subdir = ""): ?string {
    if (!isset($file['name']) || $file['error'] !== UPLOAD_ERR_OK) return null;

    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return null;

    $base = __DIR__ . "/../../uploads";
    if (!is_dir($base)) mkdir($base, 0775, true);
    if ($subdir) {
        $base .= "/".$subdir;
        if (!is_dir($base)) mkdir($base, 0775, true);
    }

    // Nom unique
    $name = uniqid("img_", true).".".$ext;
    $dest = $base . "/" . $name;

    // Sécurité basique
    if ($file['size'] > 5 * 1024 * 1024) return null; // 5MB max
    if (!move_uploaded_file($file['tmp_name'], $dest)) return null;

    // Retour chemin relatif depuis racine site
    return "uploads".($subdir?"/$subdir":"")."/".$name;
}

// Suppression physique d'une image
function delete_image(?string $path): void {
    if (!$path) return;
    $full = __DIR__ . "/../../" . ltrim($path, "/");
    if (is_file($full)) @unlink($full);
}

function resume_texte($content, $limite_mots = 30) {
    // 1. Remplacer les balises et entités HTML par des espaces
    $content_propre = preg_replace('/<[^>]+>|&nbsp;/', ' ', $content);

    // 2. Normaliser les espaces multiples en un seul
    $content_propre = preg_replace('/\s+/', ' ', $content_propre);

    // 3. Diviser le texte en mots
    $mots = explode(" ", $content_propre);

    if (count($mots) > $limite_mots) {
        return implode(" ", array_slice($mots, 0, $limite_mots)) . '...';
    }
    return $content_propre;
}
function format_date($date) {
    $timestamp = strtotime($date);
    if (!$timestamp) return $date; // Si erreur de format, retourne tel quel
    return date("d/m/Y H:i", $timestamp); // Format français
}
