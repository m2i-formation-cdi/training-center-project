<html>
<style>
  .content {
    position: absolute;
    left: 5%;
    top: 5%;
    width: 90%;
  }
  .logo {
    width: 174px;
    height: 144px;
  }
  .title {
    text-align: center;
  }
  table {
    margin: 20px 0;
    width: 100%;
  }
  th, td {
    width: 33%;
    padding: 10px;
  }
  th {
    border-bottom: 1px solid #ccc;
  }
  td {
    border-bottom: 1px solid #eee;
  }
</style>
<body>

<div class="content">
  <h1 class="title">Feuille de présence</h1>
  <p><strong>Formation</strong> : <?= $session['program_label']; ?></p>
  <p><strong>Session</strong> : <?= $session['session_code']; ?></p>
  <p><strong>Période</strong> : du <?= $session['session_start']; ?> au <?= $session['session_end']; ?></p>
  <p><strong>Nombre de participants</strong> : <?= $session['session_nb_persons']; ?></p>
  <p>Liste des participants</p>
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Date de naissance</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($participants as $participant): ?>
      <tr>
        <td><?= strtoupper($participant['person_name']); ?></td>
        <td><?= $participant['person_firstname']; ?></td>
        <td><?= $participant['person_birthdate']; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>

</body>
</html>