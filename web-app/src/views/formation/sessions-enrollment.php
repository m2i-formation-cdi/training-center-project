<h1>Feuilles de présences des formations</h1>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Session</th>
      <th>Participants</th>
      <th>Début</th>
      <th>Fin</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($sessions as $session): ?>
    <tr>
      <td><?= $session['program_label'] . ' [' . $session['session_code'] . ']'; ?></td>
      <td><?= $session['session_nb_persons']; ?></td>
      <td><?= $session['session_start']; ?></td>
      <td><?= $session['session_end']; ?></td>
      <td><a href="/formations/presence/<?= $session['session_id']; ?>" target="enrollment" class="label label-primary label-xs print-enrollment-sheet">imprimer</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>