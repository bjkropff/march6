<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Contact.php";

  session_start();

  if (empty ($_SESSION['list_of_contacts'])) {
    $_SESSION['list_of_contacts'] = array();

    }

  $app = new Silex\Application();

  $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__."/../views"
  ));

  $app->get("/", function() use ($app) {
    return $app['twig']->render('contacts.twig', array('contact' => Contact::getAll()));
  });

  $app->post("/create_contact", function() use ($app) {
    $contact = new Contact($_POST['name'], $_POST['phone'], $_POST['address']);
    $contact->save();
    return $app['twig']->render('add.twig', array('newContact' => $contact));
    $contact->save();

  });

  $app->post("/delete_contacts", function() use ($app) {
    Contact::deleteAll();
    return $app['twig']->render('delete.twig');
  });

  return $app;

?>
