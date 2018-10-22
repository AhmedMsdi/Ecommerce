<?php

namespace MainBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MainController extends Controller
{
    public function indexAction(Request $request)
    {
        $comp = array();
        $panier = array();
       // $this->get('session')->clear();
       //$this->get('session')->set('cmp',$comp );

        $serializer = new Serializer(array(new ObjectNormalizer()));
        $em = $this->getDoctrine()->getManager();
        $products=$em->getRepository('AppBundle:Product')->findBy(array(
            'isavailable'=>true));

        $pubs=$em->getRepository('AppBundle:Publicite')->findBy(array(
            'position'=>1));
        $pubs2=$em->getRepository('AppBundle:Publicite')->findBy(array(
            'position'=>2));
        $categ =$em->getRepository('AppBundle:Categorie')->findAll();
        $quote =$em->getRepository('AppBundle:Quote')->findAll();
        $ev =$em->getRepository('AppBundle:Event')->findAll();
        if ($this->get('session')->get('panier')==null){
            $panier = array();
        }else{
            $panier=$this->get('session')->get('panier');
        }
        if($request->isXmlHttpRequest()){
            if($request->get('panier')!=null)
            {
                ////////////

                /// ///////////////////////
                if ($this->get('session')->get('panier')==null){
                    $panier = array();
                }else{
                    $panier=$this->get('session')->get('panier');
                }
                $pp=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("prodid")));
                $pp->setQty($request->get("qt"));
                if (false !== $key = array_search( $serializer->normalize($pp), $panier)) {
                    return new JsonResponse("no");
                }
                array_push($panier, $serializer->normalize($pp));
                $this->get('session')->set('panier',$panier );
                $data = $serializer->normalize($panier);
                return new JsonResponse($data);

            }
            if($request->get('testp')!=null)
            {
                if ($this->get('session')->get('cmp')==null){
                    $comp = array();
                }else{
                    $comp=$this->get('session')->get('cmp');
                }


                $p=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("test")));


                if (false !== $key = array_search( $serializer->normalize($p), $comp)) {
                    return new JsonResponse("no");
                }
                array_push($comp, $serializer->normalize($p));

                $this->get('session')->set('cmp',$comp );
                $data = $serializer->normalize($comp);
                return new JsonResponse($data);

            }
            if($request->get('qv')!=null)
            {
                $data = array();
                $pqv=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("idqv")));
                array_push($panier, $serializer->normalize($pqv));
                array_push($data, $serializer->normalize($pqv));
                //$data = $serializer->normalize($pqv);
                return new JsonResponse($data);

            }
            if($request->get('rech')!=null)
            {
                $ch=$em->getRepository('AppBundle:Product')->findBy(array(
                    'name'=>$request->get("prodidrech")));
               //array_push($panier, $serializer->normalize($ch));
                $data = $serializer->normalize($ch);
                return new JsonResponse($data);

            }



          //  $comp[$p->getId()] = $serializer->normalize($p);
            if($request->get('cancel')!=null)
            {
                if ($this->get('session')->get('cmp')==null){
                    $comp = array();
                }else{
                    $comp=$this->get('session')->get('cmp');
                }
                $pc=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("idno")));
                if (false !== $key = array_search( $serializer->normalize($pc), $comp)) {
                    unset($comp[$key]);
                    $comp=array_filter($comp);
                }


                $this->get('session')->set('cmp',$comp );
                $data = $serializer->normalize($comp);
                return new JsonResponse($data);

            }
            if($request->get('cancelpan')!=null)
            {
                $pcnp=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("idnop")));
                $pcnp->setQty($request->get("panqt"));
                if (false !== $key = array_search( $serializer->normalize($pcnp), $panier)) {
                    unset($panier[$key]);
                    $panier=array_filter($panier);

                }
                $this->get('session')->set('panier',$panier );
                $data = $serializer->normalize($panier);
                return new JsonResponse($data);

            }
            if($request->get('cancel')!=null)
            {
                $pc=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("idno")));
                if (false !== $key = array_search( $serializer->normalize($pc), $comp)) {
                    unset($comp[$key]);
                    $comp=array_filter($comp);
                }


            }


        }
        return $this->render('MainBundle:ecom:index.html.twig', array(
            "categ"=>$categ,
            "prods"=>$products,
            "pubs"=>$pubs,
            "pubs2"=>$pubs2,
            "quote"=>$quote,
            "ev"=>$ev,
            "initcmp"=> $this->get('session')->get('cmp' ),
            "initpan"=> $this->get('session')->get('panier' ),

        ));
    }

    public function detailAction(Product $idProduct)
    {
        $em = $this->getDoctrine()->getManager();
        $produits=$em->getRepository("AppBundle:Product")->find($idProduct);
        $cars = array("Volvo", "BMW", "Toyota","test");
        return $this->render('MainBundle:ecom:productDetail.html.twig', array(
            "categ"=>$cars,
            "produits"=>$produits
        ));
    }

    public function panierAction(Request $request)
    {
        $comp = array();
        $panier = array();
        //$this->get('session')->clear();
        //$this->get('session')->set('cmp',$comp );

        $serializer = new Serializer(array(new ObjectNormalizer()));
        $em = $this->getDoctrine()->getManager();
        $products=$em->getRepository('AppBundle:Product')->findAll();
        $pubs=$em->getRepository('AppBundle:Publicite')->findAll();
        $categ =$em->getRepository('AppBundle:Categorie')->findAll();
        if ($this->get('session')->get('panier')==null){
            $panier = array();
        }else{
            $panier=$this->get('session')->get('panier');
        }
        if($request->isXmlHttpRequest()){
            if($request->get('panier')!=null)
            {
                ////////////

                /// ///////////////////////
                if ($this->get('session')->get('panier')==null){
                    $panier = array();
                }else{
                    $panier=$this->get('session')->get('panier');
                }
                $pp=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("prodid")));
                $pp->setQty($request->get("qt"));
                if (false !== $key = array_search( $serializer->normalize($pp), $panier)) {
                    return new JsonResponse("no");
                }
                array_push($panier, $serializer->normalize($pp));
                $this->get('session')->set('panier',$panier );
                $data = $serializer->normalize($panier);
                return new JsonResponse($data);

            }
            if($request->get('testp')!=null)
            {
                if ($this->get('session')->get('cmp')==null){
                    $comp = array();
                }else{
                    $comp=$this->get('session')->get('cmp');
                }


                $p=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("test")));


                if (false !== $key = array_search( $serializer->normalize($p), $comp)) {
                    return new JsonResponse("no");
                }
                array_push($comp, $serializer->normalize($p));

                $this->get('session')->set('cmp',$comp );
                $data = $serializer->normalize($comp);
                return new JsonResponse($data);

            }
            if($request->get('qv')!=null)
            {
                $data = array();
                $pqv=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("idqv")));
                array_push($panier, $serializer->normalize($pqv));
                array_push($data, $serializer->normalize($pqv));
                //$data = $serializer->normalize($pqv);
                return new JsonResponse($data);

            }
            if($request->get('rech')!=null)
            {
                $ch=$em->getRepository('AppBundle:Product')->findBy(array(
                    'name'=>$request->get("prodidrech")));
                //array_push($panier, $serializer->normalize($ch));
                $data = $serializer->normalize($ch);
                return new JsonResponse($data);

            }



            //  $comp[$p->getId()] = $serializer->normalize($p);
            if($request->get('cancel')!=null)
            {
                if ($this->get('session')->get('cmp')==null){
                    $comp = array();
                }else{
                    $comp=$this->get('session')->get('cmp');
                }
                $pc=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("idno")));
                if (false !== $key = array_search( $serializer->normalize($pc), $comp)) {
                    unset($comp[$key]);
                    $comp=array_filter($comp);
                }


                $this->get('session')->set('cmp',$comp );
                $data = $serializer->normalize($comp);
                return new JsonResponse($data);

            }
            if($request->get('cancelpan')!=null)
            {
                $pcnp=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("idnop")));
                $pcnp->setQty($request->get("panqt"));
                if (false !== $key = array_search( $serializer->normalize($pcnp), $panier)) {
                    unset($panier[$key]);
                    $panier=array_filter($panier);
                }
                $this->get('session')->set('panier',$panier );
                $data = $serializer->normalize($panier);
                return new JsonResponse($data);

            }
            if($request->get('cancel')!=null)
            {
                $pc=$em->getRepository('AppBundle:Product')->findOneBy(array(
                    'id'=>$request->get("idno")));
                if (false !== $key = array_search( $serializer->normalize($pc), $comp)) {
                    unset($comp[$key]);
                    $comp=array_filter($comp);
                }


            }


        }
        return $this->render('MainBundle:ecom:panier.html.twig', array(
            "categ"=>$categ,
            "prods"=>$products,
            "pubs"=>$pubs,
            "initcmp"=> $this->get('session')->get('cmp' ),
            "initpan"=> $this->get('session')->get('panier' ),

        ));
    }

    public function rechAction()
    {
        ///////////////////////////////


        ////////////////////////////////////////
        $cars = array("Volvo", "BMW", "Toyota","test");
        return $this->render('MainBundle:ecom:recherche.html.twig', array(
            "categ"=>$cars,

            "initcmp"=> $this->get('session')->get('cmp' ),
            "initpan"=> $this->get('session')->get('panier' ),
        ));
    }
}
