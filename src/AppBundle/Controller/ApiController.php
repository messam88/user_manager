<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Route("/api")
 */
class ApiController extends Controller {

    /**
     * @Route("/users/{id}", name="api_users")
     * @Method({"GET", "POST", "DELETE"})
     * @ApiDoc(
     *  section="Users",
     *  description="Get users list | View user info | Add new user | Update user info | Delete user",
     *  filters={},
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="user id"}
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="user name"},
     *      {"name"="group_id", "dataType"="integer", "required"=true, "description"="group id"}
     * },
     *  tags={"done",},
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function usersAction(Request $request, $id = null) {
        $em = $this->getDoctrine()->getEntityManager();
        $requestMethod = $request->getMethod();
        $return = [];
        if ($requestMethod == 'GET') {
            $return = $em->getRepository('AppBundle:User')->get($id);
        } else if ($requestMethod == 'POST') {
            $userName = $request->request->get('name');
            $userGroupId = $request->request->get('group_id');
            $return = $em->getRepository('AppBundle:User')->post($id, $userName, $userGroupId);
        } else if ($requestMethod == 'DELETE') {
            $return = $em->getRepository('AppBundle:User')->delete($id);
        } else {
            $return['message'] = 'bad request method';
        }
        return new JsonResponse($return);
    }

    /**
     * @Route("/groups/{id}", name="api_groups")
     * @Method({"GET", "POST", "DELETE"})
     * @ApiDoc(
     *  section="Groups",
     *  description="Get groups list | View group info | Add new group | Update group info | Delete group",
     *  filters={},
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="group id"}
     *  },
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="group name"}
     * },
     *  tags={"done",},
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function groupsAction(Request $request, $id = null) {
        $em = $this->getDoctrine()->getEntityManager();
        $requestMethod = $request->getMethod();
        $return = [];
        if ($requestMethod == 'GET') {
            $return = $em->getRepository('AppBundle:Group')->get($id);
        } else if ($requestMethod == 'POST') {
            $groupName = $request->request->get('name');
            $return = $em->getRepository('AppBundle:Group')->post($id, $groupName);
        } else if ($requestMethod == 'DELETE') {
            $return = $em->getRepository('AppBundle:Group')->delete($id);
        } else {
            $return['message'] = 'bad request method';
        }
        return new JsonResponse($return);
    }

    /**
     * @Route("/groups/{id}/users/{uid}", name="api_groups_users")
     * @Method({"GET", "POST", "DELETE"})
     * @ApiDoc(
     *  section="Groups",
     *  description="Get group users list | Add user to group or Update user group | Delete user from group",
     *  filters={},
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="group id"},
     *      {"name"="uid", "dataType"="integer", "requirement"="\d+", "description"="user id"}
     *  },
     *  parameters={     
     * },
     *  tags={"done",},
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function groupsUsersAction(Request $request, $id = null, $uid = null) {
        $em = $this->getDoctrine()->getEntityManager();
        $requestMethod = $request->getMethod();
        $return = [];
        if ($requestMethod == 'GET') {
            $return = $em->getRepository('AppBundle:Group')->getUsers($id);
        } else if ($requestMethod == 'POST' || $requestMethod == 'DELETE') {
            $return = $em->getRepository('AppBundle:Group')->userGroup($id, $uid, $requestMethod);
        } else {
            $return['message'] = 'bad request method';
        }
        return new JsonResponse($return);
    }

}
