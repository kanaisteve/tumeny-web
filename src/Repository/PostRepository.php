<?php

namespace App\Repository;

use App\Entity\Post;
use App\Service\ImageUploader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    private $slugger;
    private $imageUploader;
    public function __construct(ManagerRegistry $registry, SluggerInterface $slugger, ImageUploader $imageUploader)
    {
        parent::__construct($registry, Post::class);
        $this->slugger = $slugger;
        $this->imageUploader = $imageUploader;
    }

    public function add(Post $post, FormInterface $form, string $targetDirectory, bool $flush = false): void
    {
        $post = $form->getData();

        $thumbnail = $form->get('imagePath')->getData();
        if ($thumbnail) {   // thumbnail must be processed only when a file is uploaded
            $avatar = $this->imageUploader->upload($thumbnail);
            $post->setImagePath($thumbnail); // store the post image name instead of its contents
        }

        $post->setCreatedAt(new \DateTime('now'));
        $this->getEntityManager()->persist($post);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function addWithFile(Post $post, FormInterface $form, UserInterface $user, string $postsDirectory, bool $flush = false): void
    {
        $post = $form->getData();
        $slug = strtolower($this->slugger->slug($form->get('title')->getData()));

        $postImg = $form->get('imagePath')->getData();
        if ($postImg) {   // thumbnail must be processed only when a file is uploaded
            $originalFilename = pathinfo($postImg->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $this->slugger->slug($originalFilename);    // this is needed to safely include the file name as part of the URL
            $newFilename = $safeFilename.'-'.uniqid().'.'.$postImg->guessExtension();

            try {   // Move the file to the directory where posts are stored
                $postImg->move($postsDirectory, $newFilename);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // store the post image name instead of its contents
            //$post->setImagePath($newFilename);
            $post->setImagePath($newFilename);
        }

        $post->setSlug($slug);
        $post->setUser($user);
        $post->setCreatedAt(new \DateTime('now'));
        $post->setupdatedAt(new \DateTime('now'));
        $this->getEntityManager()->persist($post);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPostWithCategory(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->select('p.title')
            ->where('p.id = :id')
            ->setParameter('id', $id);

        return $queryBuilder->getQuery()->getResult();
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function getPublishedPosts(): array
    {
        $status = 'published';
        return $this->createQueryBuilder('p')
            ->andWhere('p.status = :status')
            ->setParameter('status', $status)
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function latest()
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->select('p')
            ->orderBy('p.createdAt', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function getTodayPosts(): array
    {
        // $currentDate = new \DateTime();
        $date  = new \DateTimeImmutable();
        $today = $date->format('Y-m-d');
        $status = 'published';

        $queryBuilder = $this->createQueryBuilder('p');
        $query = $queryBuilder
            ->select(array('p'))
            ->from('App\Entity\Post', 'p')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('p.status', ':status'),
                    $queryBuilder->expr()->eq('p.createdAt', ':date')
                )
            )
            ->setParameter('status', $status)
//            ->setParameter('date', $today)
            ->orderBy('p.createdAt', 'DESC')
//            ->setMaxResults(5)
            ->getQuery();

        return $query->getResult();
        ;
    }

//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
