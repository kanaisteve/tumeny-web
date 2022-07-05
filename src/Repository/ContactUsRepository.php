<?php

namespace App\Repository;

use App\Entity\ContactUs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * @extends ServiceEntityRepository<ContactUs>
 *
 * @method ContactUs|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactUs|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactUs[]    findAll()
 * @method ContactUs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactUsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactUs::class);
    }

    public function add(ContactUs $msg, FormInterface $form, bool $flush = false): void
    {
        $msg = $form->getData();
        $msg->setStatus('pending');

        $msg->setCreatedAt(new \DateTime('now'));
        $msg->setupdatedAt(new \DateTime('now'));

        $this->getEntityManager()->persist($msg);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function latestQueries()
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder->select('c')
            ->orderBy('c.id', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }

    public function sendEmail(FormInterface $form,  MailerInterface $mailer): void
    {
        $name = $form->get('name')->getData();
        $email = $form->get('email')->getData();
        $mobile = $form->get('mobileNumber')->getData();
        $subject = $form->get('subject')->getData();
        $body = $form->get('body')->getData();

        // send email
        $email = (new TemplatedEmail())
            ->from(new Address($email, $name))
            ->to(new Address('kanaistevew@gmail.com', 'Kanai Technologies'))
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)

            // path of the Twig template to render
            ->htmlTemplate('emails/contact_us.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'name' => $name,
                'mobile_number' => $mobile,
                'user_email' => $email,
                'subject' => $subject,
                'body' => $body,
            ])
        ;

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
        }
    }

    public function remove(ContactUs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTodayQueries(): array
    {
        // $currentDate = new \DateTime();
        $date  = new \DateTimeImmutable();
        $today = $date->format('Y-m-d');
        $status = 'pending';

        $queryBuilder = $this->createQueryBuilder('c');
        $query = $queryBuilder
            ->select(array('c'))
            ->from('App\Entity\ContactUs', 'c')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('c.status', ':status'),
                    $queryBuilder->expr()->eq('c.createdAt', ':date')
                )
            )
            ->setParameter('status', $status)
            ->setParameter('date', $today)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery();

        return $query->getResult();
        ;
    }

//    /**
//     * @return ContactUs[] Returns an array of ContactUs objects
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

//    public function findOneBySomeField($value): ?ContactUs
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
