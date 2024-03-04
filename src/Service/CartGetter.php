<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Cart;

class CartGetter
{
    private $session;
	private $em;
	private $security;

    public function __construct(
        SessionInterface $sessionInterface,
		EntityManagerInterface $entityManager,
		Security $security
    ) {
        $this->session = $sessionInterface;
		$this->em = $entityManager;
		$this->security = $security;
    }

    public function getCart()
    {
        $user = $this->security->getUser();

        if (!$user) {
            $cart = $this->getUnathenticatedUserCart();
        }else{
			$cart = $user->getCart();
		}

        return $cart;
    }

    public function getUnathenticatedUserCart()
    {
        $cartId = $this->session->get('cartId');

        if (!$cartId) {
			return $this->addSessionCart();
        }

        $cart = $this->em->getRepository(Cart::class)->find($cartId);

		if(is_null($cart)) {
			return $this->addSessionCart();
		}
		
        return $cart;
    }

	public function addSessionCart(){
		$cart = new Cart();
		$this->em->persist($cart);
		$this->em->flush();

		$this->session->set('cartId', $cart->getId());

		return $cart;	
	}
}
?>
