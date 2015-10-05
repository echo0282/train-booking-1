<?php

namespace BBC\TrainBooking;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is the entry point and will control the actions
 *
 * Class TrainBooking
 * @package BBC\TrainBooking
 */
class TrainBooking
{
    private $app;

    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }

    /**
     * Controls the index action
     *
     * @return string
     */
    public function indexAction()
    {
        return $this->app['twig']->render(
            'index.twig'
        );
    }

    /**
     * Controls the get action
     *
     * @return Response
     */
    public function getAction()
    {
        $this->app['bookings.service']->get();
        $json = $this->app['bookings.service']->transform();
        $response = new Response($json, 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Controls the put action
     *
     * @param $data
     * @return JsonResponse
     */
    public function putAction($data)
    {
        if ($this->app['bookings.service']->verify($data)) {
            $data = $this->app['bookings.service']->sanitise($data);
            $this->app['bookings.service']->put($data);

            return new JsonResponse(array("success"), 200);
        }

        return new JsonResponse(array("fail"), 500);
    }

    /**
     * Controls the delete action
     *
     * @param array $data
     * @return string
     */
    public function deleteAction($data = [])
    {
        $res = $this->app['bookings.service']->delete($data);

        if ($res) {
            return $this->app['twig']->render(
                'index.twig',
                array(
                    'notice' => "Deleted ID $data successfully"
                )
            );
        }

        return $this->app['twig']->render(
            'index.twig',
            array(
                'notice' => "Not Deleted ID $data successfully"
            )
        );
    }

    /**
     * Controls the config action
     *
     * @return JsonResponse
     */
    public function configAction()
    {
        // If I had more time, maybe put this to a config file
        return new JsonResponse(
            array(
                "inactive" => array(
                    "5"
                ),
                "cols" => array(
                    (object) array(
                        "position" => "left",
                        "perRow" => 3,
                        "rows"  => 13
                    ),
                    (object) array(
                        "position" => "right",
                        "perRow" => 2,
                        "rows"  => 14
                    )
                )
            )
        );
    }
}
