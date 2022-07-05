<?php

namespace App\Repository;

use App\Entity\Testimonial;
use App\Service\AvatarUploader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @extends ServiceEntityRepository<Testimonial>
 *
 * @method Testimonial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testimonial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testimonial[]    findAll()
 * @method Testimonial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestimonialRepository extends ServiceEntityRepository
{
    private $slugger;
    private $avatarUploader;
    public function __construct(ManagerRegistry $registry, SluggerInterface $slugger, AvatarUploader $avatarUploader)
    {
        parent::__construct($registry, Testimonial::class);
        $this->slugger = $slugger;
        $this->avatarUploader = $avatarUploader;
    }

    public function add(Testimonial $testimonial, FormInterface $form, bool $flush = false): void
    {
        $testimonial = $form->getData();

        /** @var UploadedFile $avatar */
        $avatar = $form->get('avatar')->getData();
        if ($avatar) {
            $avatar = $this->avatarUploader->upload($avatar);
            $testimonial->setAvatar($avatar);
        }

        $testimonial->setCreatedAt(new \DateTime('now'));
        // $testimonial->setCreatedAt(new \DateTime('tomorrow'));

        $this->getEntityManager()->persist($testimonial);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function addWithFile(Testimonial $testimonial, FormInterface $form, string $targetDirectory,  bool $flush = false): void
    {
        $testimonial = $form->getData();

        $avatar = $form->get('imagePath')->getData();
        if ($avatar) {   // thumbnail must be processed only when a file is uploaded
            $originalFilename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $this->slugger->slug($originalFilename);    // this is needed to safely include the file name as part of the URL
            $newFilename = $safeFilename.'-'.uniqid().'.'.$avatar->guessExtension();

            try {   // Move the file to the directory where posts are stored
                $avatar->move($targetDirectory, $newFilename);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // store the post image name instead of its contents
            $testimonial->setAvatar($newFilename);
        }

        $this->getEntityManager()->persist($testimonial);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Testimonial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Testimonial[] Returns an array of Testimonial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Testimonial
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
