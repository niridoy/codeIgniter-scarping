<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class CompanyController extends AbstractController
{
    protected $companyRepository;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->companyRepository = $entityManager->getRepository(Company::class);
    }

    #[Route(path: '/companies', name: 'companies.index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        return $this->render('index.html.twig', ['pagination' => $this->companyRepository->paginate(10, $request, $paginator)]);
    }

    #[Route(path: '/companies/create', name: 'companies.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $company = new Company();

        $form = $this->createFormBuilder($company)
            // ->setAction($this->generateUrl('companies.store'))
            ->add('name', TextType::class)
            ->add('registrationCode', TextType::class)
            ->add('Phone', TextType::class)
            ->add('vatNo', TextType::class)
            ->add('address', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $company = $form->getData();
               // dd($company);
                $this->companyRepository->save($company, true);

                flash()->addSuccess('Company has beed created successfully!');
                
                return $this->render('company/create.html.twig', [
                    'form' => $form->createView(),
                    'form_type' => "Create"
                ]);
            }

        return $this->render('company/create.html.twig', [
            'form' => $form,
            'form_type' => "Edit"
        ]);
    }

    #[Route(path: '/companies/edit/{id}', name: 'companies.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id): Response
    { 
        
        $company = $this->companyRepository->find($id);

        $form = $this->createFormBuilder($company)
            // ->setAction($this->generateUrl('companies.store'))
            ->add('name', TextType::class)
            ->add('registrationCode', TextType::class)
            ->add('Phone', TextType::class)
            ->add('vatNo', TextType::class)
            ->add('address', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $company = $form->getData();
               // dd($company);
                $this->companyRepository->save($company, true);

                flash()->addSuccess('Company has beed updated successfully!');
                
                return $this->render('company/create.html.twig', [
                    'form' => $form->createView(),
                    'form_type' => "Edit"
                ]);
            }

        return $this->render('company/create.html.twig', [
            'form' => $form,
            'form_type' => "Edit"
        ]);
    }

    #[Route(path: '/companies/crawling', name: 'companies.crawling', methods: ['GET', 'POST'])]
    public function crawling() 
    {
        return $this->companyRepository->crawling();;
    }
}
