<?php

namespace App\Controller;

use App\Service\CartGetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\CartItem;
use App\Entity\Product;

class CartController extends AbstractController
{
	private $cartGetter;
	private $em;

	public function __construct(
		CartGetter $cartGetter,
		EntityManagerInterface $entityManager,
	) {
		$this->cartGetter = $cartGetter;
		$this->em = $entityManager;
	}

	/**
	 * @Route("/cart", name="cart")
	 */
	public function getCart(): Response
	{
		return $this->render("pages/cart.twig", [
			"controller_name" => "CartController",
		]);
	}

	/**
	 * @Route("/cart-remove-product", name="cart-remove-product")
	 */
	public function cartRemoveProduct(Request $request)
	{
		$id = json_decode($request->getContent(), true)['id'];
		$cartItem = $this->em->getRepository(CartItem::class)->find($id);
		$this->em->remove($cartItem);
		$this->em->flush();

		return $this->json(['message'=>'product removed']);
	}

	/**
	 * @Route("/cart-add-product", name="cart-add-product")
	 */
	public function cartAddProduct(Request $request)
	{
		$requestContent = json_decode($request->getContent(), true);
		$productId = $requestContent['productId'];
		$amount = $requestContent['amount'];
		$operation = $requestContent['operation'];

		$cart = $this->cartGetter->getCart();
		$cartItem = $this->em->getRepository(CartItem::class)->findOneBy(['cart'=>$cart->getId(), 'product'=>$productId]);
		
		$product = $this->em->getRepository(Product::class)->find($productId);
		$productQuantity = $product->getQuantity();

		if(is_null($cartItem)){
			$availableAmount = min($productQuantity, $amount);
			$this->addCartItem($cart, $productId, $availableAmount);
		}else{
			$availableAmount = min($productQuantity - $cartItem->getAmount(), $amount);
			$this->changeCartItemAmount($cartItem, $operation, $availableAmount);
		}

		$error = null;
		if($availableAmount < $amount){
			$error = 'Za mało produktu na stanie. Dodano do koszyka '.$availableAmount.' '.$product->getName();
		}

		return $this->json(['message'=>'product added', 'error'=>$error]);
	}

	/**
	 * @Route("/cart-items", name="cart-items")
	 */
	public function cartItems()
	{
		return $this->render("components/cart-items.twig", [
			"controller_name" => "CartController",
		]);
	}

	/**
	 * @Route("/cart-dropdown-items", name="cart-dropdown-items")
	 */
	public function cartDropdownItems()
	{
		return $this->render("components/cart-dropdown-items.twig", [
			"controller_name" => "CartController",
		]);
	}

	public function addCartItem($cart, $productId, $amount){

		$product = $this->em->getRepository(Product::class)->find($productId);

		$cartItem = new CartItem();
		$cartItem->setProduct($product);
		$cartItem->setAmount($amount);
		$cartItem->setCart($cart);

		$cart->addCartItem($cartItem);

		$this->em->persist($cartItem);
		$this->em->persist($cart);
		$this->em->flush();
	}

	public function changeCartItemAmount($cartItem, $operation, $value){
		if($operation == '='){
			$cartItem->setAmount($value);
		}
		else if($operation == '+'){
			$cartItem->setAmount($cartItem->getAmount() + $value);
		}
		else if($operation == '-'){
			$cartItem->setAmount($cartItem->getAmount() - $value);
		}
		$this->em->persist($cartItem);
		$this->em->flush();
	}
}
