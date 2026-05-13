<?php
// Admin Dashboard
require_once '../config.php';

// Require login
requireLogin();

// Get database connection
$conn = getDBConnection();

// Handle project actions (add, edit, delete)
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add' || $action === 'edit') {
        $title = sanitizeInput($_POST['title'] ?? '');
        $description = sanitizeInput($_POST['description'] ?? '');
        $tags = sanitizeInput($_POST['tags'] ?? '');
        $link = sanitizeInput($_POST['link'] ?? '');
        $image_url = sanitizeInput($_POST['image_url'] ?? '');
        
        if (empty($title) || empty($description)) {
            $message = 'Title and description are required';
            $messageType = 'error';
        } else {
            if ($action === 'add') {
                $stmt = $conn->prepare("INSERT INTO projects (title, description, tags, link, image_url) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $title, $description, $tags, $link, $image_url);
            } else {
                $id = (int)$_POST['project_id'];
                $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, tags=?, link=?, image_url=? WHERE id=?");
                $stmt->bind_param("sssssi", $title, $description, $tags, $link, $image_url, $id);
            }
            
            if ($stmt->execute()) {
                $message = $action === 'add' ? 'Project added successfully!' : 'Project updated successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error saving project';
                $messageType = 'error';
            }
            $stmt->close();
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['project_id'];
        $stmt = $conn->prepare("DELETE FROM projects WHERE id=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $message = 'Project deleted successfully!';
            $messageType = 'success';
        } else {
            $message = 'Error deleting project';
            $messageType = 'error';
        }
        $stmt->close();
    }
}

// Fetch all projects
$projects_result = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = [];
while ($row = $projects_result->fetch_assoc()) {
    $projects[] = $row;
}

// Fetch contact messages
$contacts_result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 10");
$contacts = [];
while ($row = $contacts_result->fetch_assoc()) {
    $contacts[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-container {
            min-height: 100vh;
            background-color: var(--bg-alt);
        }
        .dashboard-header {
            background-color: var(--bg-color);
            padding: 1rem 2rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-header h1 {
            color: var(--text-color);
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-info span {
            color: var(--text-color);
        }
        .btn-logout {
            padding: 0.5rem 1rem;
            background-color: var(--error-color);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }
        .dashboard-content {
            padding: 2rem;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        .card {
            background-color: var(--bg-color);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        .card h2 {
            color: var(--text-color);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-add {
            padding: 0.5rem 1rem;
            background-color: var(--success-color);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .project-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .project-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: var(--bg-alt);
            border-radius: 8px;
        }
        .project-info h3 {
            color: var(--text-color);
            margin-bottom: 0.25rem;
        }
        .project-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        .project-actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn-edit {
            padding: 0.4rem 0.8rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
        }
        .btn-delete {
            padding: 0.4rem 0.8rem;
            background-color: var(--error-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
        }
        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .contact-item {
            padding: 1rem;
            background-color: var(--bg-alt);
            border-radius: 8px;
        }
        .contact-item h4 {
            color: var(--text-color);
            margin-bottom: 0.25rem;
        }
        .contact-item p {
            color: var(--text-light);
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }
        .contact-date {
            color: var(--text-light);
            font-size: 0.8rem;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background-color: var(--bg-color);
            padding: 2rem;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .modal-header h2 {
            color: var(--text-color);
        }
        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-color);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .alert-success {
            background-color: var(--success-color);
            color: white;
        }
        .alert-error {
            background-color: var(--error-color);
            color: white;
        }
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <div class="user-info">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </header>
        
        <main class="dashboard-content">
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div class="dashboard-grid">
                <div class="card">
                    <h2>
                        Projects
                        <button class="btn-add" onclick="openModal('add')">
                            <i class="fas fa-plus"></i> Add Project
                        </button>
                    </h2>
                    <div class="project-list">
                        <?php if (empty($projects)): ?>
                            <p style="color: var(--text-light);">No projects yet. Add your first project!</p>
                        <?php else: ?>
                            <?php foreach ($projects as $project): ?>
                                <div class="project-item">
                                    <div class="project-info">
                                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                                        <p><?php echo htmlspecialchars(substr($project['description'], 0, 100)) . '...'; ?></p>
                                    </div>
                                    <div class="project-actions">
                                        <button class="btn-edit" onclick="openModal('edit', <?php echo $project['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this project?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card">
                    <h2>Recent Messages</h2>
                    <div class="contact-list">
                        <?php if (empty($contacts)): ?>
                            <p style="color: var(--text-light);">No messages yet.</p>
                        <?php else: ?>
                            <?php foreach ($contacts as $contact): ?>
                                <div class="contact-item">
                                    <h4><?php echo htmlspecialchars($contact['name']); ?></h4>
                                    <p><?php echo htmlspecialchars($contact['email']); ?></p>
                                    <p><?php echo htmlspecialchars(substr($contact['message'], 0, 50)) . '...'; ?></p>
                                    <p class="contact-date"><?php echo date('M j, Y', strtotime($contact['created_at'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Modal for Add/Edit Project -->
    <div class="modal" id="projectModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Project</h2>
                <button class="btn-close" onclick="closeModal()">&times;</button>
            </div>
            <form method="POST" id="projectForm">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="project_id" id="projectId">
                
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="tags">Tags (comma-separated)</label>
                    <input type="text" id="tags" name="tags" placeholder="PHP, MySQL, JavaScript">
                </div>
                
                <div class="form-group">
                    <label for="link">Project Link</label>
                    <input type="text" id="link" name="link" placeholder="https://...">
                </div>
                
                <div class="form-group">
                    <label for="image_url">Image URL</label>
                    <input type="text" id="image_url" name="image_url" placeholder="https://...">
                </div>
                
                <button type="submit" class="btn-submit">Save Project</button>
            </form>
        </div>
    </div>
    
    <script>
        // Store projects data for editing
        const projects = <?php echo json_encode($projects); ?>;
        
        function openModal(action, projectId = null) {
            const modal = document.getElementById('projectModal');
            const formAction = document.getElementById('formAction');
            const projectIdInput = document.getElementById('projectId');
            const modalTitle = document.getElementById('modalTitle');
            
            formAction.value = action;
            projectIdInput.value = projectId || '';
            
            if (action === 'edit' && projectId) {
                const project = projects.find(p => p.id === projectId);
                if (project) {
                    document.getElementById('title').value = project.title;
                    document.getElementById('description').value = project.description;
                    document.getElementById('tags').value = project.tags || '';
                    document.getElementById('link').value = project.link || '';
                    document.getElementById('image_url').value = project.image_url || '';
                    modalTitle.textContent = 'Edit Project';
                }
            } else {
                document.getElementById('projectForm').reset();
                modalTitle.textContent = 'Add Project';
            }
            
            modal.classList.add('active');
        }
        
        function closeModal() {
            const modal = document.getElementById('projectModal');
            modal.classList.remove('active');
        }
        
        // Close modal when clicking outside
        document.getElementById('projectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
