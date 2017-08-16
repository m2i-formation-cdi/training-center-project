<?php

namespace m2i\project\Controller;

use m2i\Framework\ServiceContainer as SC;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class TrainingController
{

  public function indexAction()
  {
    $view = SC::get("view");
    echo $view->renderView("training/index");
  }

  public function sessionsEnrollmentAction()
  {

    $sessionDAO = SC::get('session.dao');
    $sessions = $sessionDAO->findAllWithProgram()->getAllAsArray();

    $view = SC::get("view");
    echo $view->renderView("training/sessions-enrollment", [
      'sessions' => $sessions,
    ]);
  }

  public function printSessionEnrollmentAction($sessionId)
  {
    try {

      $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
      $html2pdf->pdf->SetDisplayMode('fullpage');

      $view = SC::get("view");
      $sessionDAO = SC::get('session.dao');
      $enrollmentDAO = SC::get('enrollment.dao');

      $session = $sessionDAO->findOneByIdWithProgram([$sessionId])->getOneAsArray();
      $participants = $enrollmentDAO->findPersonsBySession([$sessionId])->getAllAsArray();

      ob_start();
      echo $view->getTemplateHtml("training/session-enrollment-pdf", [
          'session' => $session,
          'participants' => $participants,
      ]);
      $content = ob_get_clean();

      $html2pdf->writeHTML($content);
      $html2pdf->output('session_' . $sessionId . '.pdf');

    } catch (Html2PdfException $e) {
      $formatter = new ExceptionFormatter($e);
      echo $formatter->getHtmlMessage();
    }
  }

}