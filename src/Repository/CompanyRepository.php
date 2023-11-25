<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    private $httpClient;

    public function __construct(ManagerRegistry $registry, HttpClientInterface $httpClient)
    {
        parent::__construct($registry, Company::class);
        $this->httpClient = $httpClient;
    }

    public function save(Company $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Company $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Company[] Returns an array of Company objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Company
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

   public function paginate($page, $request, $paginator) : mixed
   {
        $query = $this->createQueryBuilder('e')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Current page number
            $page // Number of items per page
        );
    
        return $pagination;
   }

   public function crawling($registrationCode = null)
   {
   
        // $url = 'https://facebook.com/'; // Replace with the URL you want to crawl
        $url = 'https://rekvizitai.vz.lt/en/company-search/1/'; // Replace with the URL you want to crawl
        // $proxyUrl = 'http://35.236.207.242:33333'; // Replace with your proxy server details

        // Configure HttpClient with a proxy
        $client = HttpClient::create([
            // 'proxy' => $proxyUrl,
            // Add other HttpClient options as needed
        ]);

        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Safari/537.36';

        // Make a GET request through the proxy
        $response = $client->request('POST', $url,[
            'headers' => [
               'Content-Type' => 'application/x-www-form-urlencoded', // Adjust content type if needed
            //    'User-Agent' => $userAgent,
             // 'Content-Type' => 'text/plain',
            ],
            'body' => http_build_query([
                'code' => '302680320',
            ]), 
        ]);
        // dd($response);
        dd($response->getContent());
        // Get the HTML content from the response
        $htmlContent = $response->getContent();
      
       
   }

}
