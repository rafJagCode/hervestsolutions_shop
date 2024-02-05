<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use App\Service\CartGetter;
use App\Entity\OrderItem;
use App\Entity\Order;

class OrderController extends AbstractController
{
	private $cartGetter;
	private $em;
	private $security;

    public function __construct(CartGetter $cartGetter, EntityManagerInterface $entityManager, Security $security)
    {
		$this->cartGetter = $cartGetter;
		$this->em = $entityManager;
		$this->security = $security;
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout(): Response
    {
		$cart = $this->cartGetter->getCart();
		$cartItems = $cart->getCartItem();
		if(count($cartItems) === 0){
			$this->addFlash('error', 'Twój koszyk jest pusty.');
			return $this->redirectToRoute('index');
		}
        return $this->render("pages/checkout.twig", [
            "controller_name" => "OrderController",
			"cart"=>$cart
        ]);
    }

	/**
     * @Route("/submit-order", name="submit-order")
     */
    public function submitOrder(Request $request): Response
    {
		$firstName = $request->request->get('firstName');
		$lastName = $request->request->get('lastName');
		$country = $request->request->get('country');
		$city = $request->request->get('city');
		$street = $request->request->get('street');
		$email = $request->request->get('email');
		$phone = $request->request->get('phone');
		$paymentMethod = $request->request->get('paymentMethod');
		$user = $this->security->getUser();
		$cart = $this->cartGetter->getCart();

		$order = new Order();
		$order->setCreatedAt(new \DateTime());
		$order->setStatus('pending');
		$order->setPaymentMethod($paymentMethod);
		$order->setUser($user);
		$order->setFirstName($firstName);
		$order->setLastName($lastName);
		$order->setCountry($country);
		$order->setCity($city);
		$order->setStreet($street);
		$order->setEmail($email);
		$order->setPhone($phone);
		foreach($cart->getCartItem() as $cartItem){
			$orderItem = new OrderItem();
			$orderItem->setPlacedOrder($order);
			$orderItem->setProduct($cartItem->getProduct());
			$orderItem->setAmount($cartItem->getAmount());
			$this->em->persist($orderItem);
			$order->addItem($orderItem);
			$cart->removeCartItem($cartItem);
			$this->em->persist($cart);
		}
		$this->em->persist($order);
		$this->em->flush();

		$this->container->get('session')->set('lastOrderId', $order->getId());

        return $this->redirectToRoute('order-success');
    }

	/**
     * @Route("/order-success", name="order-success")
     */
    public function orderSuccess(Request $request): Response
    {
		$lastOrderId = $this->container->get('session')->get('lastOrderId');

		if(is_null($lastOrderId)){
			$this->addFlash('error', 'Musisz złożyć zamówienie aby móc zobaczyć tę stronę.');
			return $this->redirectToRoute('index');
		}
		$order = $this->em->getRepository(Order::class)->find($lastOrderId);

        return $this->render("pages/order-success.twig", [
            "controller_name" => "OrderController",
			"order" => $order
        ]);
    }
	
	/**
     * @Route("/account-order-details/{id}", name="account-order-details")
     */
    public function orderDetails($id): Response
    {
		$user = $this->security->getUser();
		if(is_null($user)) return $this->redirectToRoute('login');

		$order = $this->em->getRepository(Order::class)->find($id);
		if(is_null($order)) throw $this->createNotFoundException();
		if($user !== $order->getUser()) return $this->redirectToRoute('login');

        return $this->render("pages/account-order-details.twig", [
            "controller_name" => "OrderController",
			"order" => $order
        ]);
    }
}
