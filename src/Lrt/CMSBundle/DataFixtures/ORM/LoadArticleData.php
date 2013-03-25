<?php

namespace Lrt\CMSBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Lrt\CMSBundle\Entity\Article;
use Lrt\SiteBundle\Entity\Activity;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $user2 = $this->getReference('julien1');
        $category = $this->getReference('category1');

        $this->newArticle($category, 'Interview de jérémy et philippe sur le Marathon de Paris 2013', $user2, '<p class="p1"><span class="s1"><b>A</b></span> deux semaines de l&#39;&eacute;dition 2013 du marathon de Paris en course &agrave; pied, les deux pensionnaires du Longchamp Roller Team, J&eacute;r&eacute;my DUBOSC et Philippe CABON, se sont pr&ecirc;t&eacute;s au jeu de l&#39;interview et nous font part de leur approche de cette &eacute;preuve mythique &agrave; laquelle ils participeront. Souhaitons leur d&#39;atteindre leurs objectifs.</p>

<p class="p2"><b>1.</b><span class="s2">&nbsp;&nbsp;</span><b>Est ce ton premier marathon en course a pied ?</b><span class="s3"><b>&nbsp;</b></span></p>

<p class="p3"><b style="line-height: 1.6em;">Jeremy :</b><span style="line-height: 1.6em;"> Et non en Novembre 2011 j&rsquo;ai particip&eacute; au marathon&nbsp;</span><span style="line-height: 1.6em;">des Alpes Maritime (Nice-Cannes), une 1</span><span class="s4" style="line-height: 1.6em;"><sup>er</sup></span><span style="line-height: 1.6em;"> exp&eacute;rience&nbsp;</span><span style="line-height: 1.6em;">tr&egrave;s difficile et sans grande pr&eacute;paration la course&nbsp;</span><span style="line-height: 1.6em;">est vite devenue un enfer.</span></p>

<p class="p1"><b>Philippe :</b> Oui, j&#39;ai d&eacute;j&agrave; fait plusieurs semi, mais jamais de Marathon</p>

<p class="p6"><b>2. &nbsp;Quel est ton objectif ?</b><span class="s3"><b>&nbsp;</b></span></p>

<p class="p3"><b style="line-height: 1.6em;">Jeremy :</b><span style="line-height: 1.6em;"> Je me suis lanc&eacute; le d&eacute;fi de ne pas d&eacute;passer&nbsp;</span><span style="line-height: 1.6em;">les 3h20 mais tout en gardant pour objectif de me&nbsp;</span><span style="line-height: 1.6em;">rapprocher au plus pr&ecirc;t des 3h00.</span></p>

<p class="p1"><span class="s5"><b>Philippe :</b> </span>Je me suis entra&icirc;n&eacute; pour 3h45&nbsp;<span style="line-height: 1.6em;">mais je n&#39;ai aucune r&eacute;f&eacute;rence, donc on verra !</span></p>

<p class="p8"><b>3. &nbsp;Quel a &eacute;t&eacute; ton programme d&#39;entra&icirc;nement ?</b><span class="s6"><b>&nbsp;</b></span></p>

<p class="p3"><b style="line-height: 1.6em;">Jeremy :</b><span style="line-height: 1.6em;"> J&rsquo;ai commenc&eacute; ma pr&eacute;paration il y &agrave; 11 semaines,&nbsp;</span><span style="line-height: 1.6em;">&agrave; raison de 5 entrainements par semaine m&eacute;langeant&nbsp;</span><span style="line-height: 1.6em;">s&eacute;ances de fractionn&eacute; et sorties longues sans oublier&nbsp;</span><span style="line-height: 1.6em;">les sorties de r&eacute;cup&eacute;ration active.&nbsp;</span></p>

<p class="p1"><b>Philippe </b>: 13 semaines d&#39;entra&icirc;nement avec 4 s&eacute;ances&nbsp;<span style="line-height: 1.6em;">par semaine dont 1 s&eacute;ance longue (jusqu&#39;&agrave; 2h30)&nbsp;</span><span style="line-height: 1.6em;">et 1 s&eacute;ance de fractionn&eacute;e</span></p>

<p class="p6"><b>4. &nbsp;Comment as tu g&eacute;r&eacute; la transition roller / CAP ?</b><span class="s3"><b>&nbsp;</b></span></p>

<p class="p1"><b>Jeremy :</b> La transition entre le Roller et la course &agrave; pieds fut&nbsp;<span style="line-height: 1.6em;">relativement facile, mais je pense qu&rsquo;elle sera beaucoup&nbsp;</span><span style="line-height: 1.6em;">plus dure dans l&rsquo;autre sens vu que j&rsquo;ai pr&eacute;f&eacute;r&eacute; couper compl&egrave;tement</span><span style="line-height: 1.6em;">ma pr&eacute;paration en roller pour pouvoir me consacrer au maximum&nbsp;</span><span style="line-height: 1.6em;">sur le marathon de Paris.</span></p>

<p class="p1"><b>Philippe :</b> Naturellement car l&#39;hiver est plus propice &agrave; la CAP,&nbsp;<span style="line-height: 1.6em;">par contre l&#39;inverse va &ecirc;tre dur car on reprend la saison roller&nbsp;</span><span style="line-height: 1.6em;">tr&egrave;s rapidement apr&egrave;s le marathon</span></p>

<p class="p6"><b>5. &nbsp;Quelle sera la bande son de ton &eacute;preuve ?&nbsp;</b></p>

<p class="p3"><b style="line-height: 1.6em;">Jeremy :</b><span style="line-height: 1.6em;"> Pour l&rsquo;instant je ne les pas encore pr&eacute;par&eacute;e,&nbsp;</span><span style="line-height: 1.6em;">&agrave; 15 jours de l&rsquo;&eacute;preuve j&rsquo;&eacute;vite de me stresser&nbsp;</span><span style="line-height: 1.6em;">avec ce genre de petit d&eacute;tail mais elle sera orient&eacute;e&nbsp;</span><span style="line-height: 1.6em;">RAP US / Techno (Florida, David Guetta)</span></p>

<p class="p1"><b>Philippe : </b>Assez vari&eacute;e, plut&ocirc;t soft au d&eacute;part (par exemple l&#39;album de Nneka)&nbsp;<span style="line-height: 1.6em;">puis plus rythm&eacute; (rap, electro)</span></p>

<p class="p8"><b>6.&nbsp;Un dernier mot ?</b><span class="s7"><b>&nbsp;</b></span></p>

<p class="p3"><b style="line-height: 1.6em;">Jeremy :</b><span style="line-height: 1.6em;"> Un grand merci &agrave; tous mes amis et famille&nbsp;</span><span style="line-height: 1.6em;">qui me soutiennent depuis plusieurs semaines dans ma pr&eacute;paration&nbsp;</span><span style="line-height: 1.6em;">en esp&eacute;rant leur faire honneur, alors rendez-vous le 7 Avril 2013 pour conclure.</span></p>

<p class="p1"><b>Philippe :</b> Ravi de me confronter &agrave; ce nouveau challenge et de le faire&nbsp;<span style="line-height: 1.6em;">avec Jeremy (enfin presque parce on devrait pas beaucoup se voir !)&quot;</span></p>', Activity::IS_VALIDATED, new \DateTime('22-03-2013'));
    
        $this->newArticle($category, 'Les 3 pistes', $user2, '<p>Le week-end prochain aura lieu la 27&egrave;me &eacute;dition de l&#39;&eacute;preuve internationale &quot;LES 3 PISTES&quot; qui se d&eacute;roule sur 3 &eacute;tapes (Pibrac, Valence d&#39;Agen et Gujan Mestras). La formation LONGCHAMP ROLLER TEAM alignera pour l&#39;occasion 3 patineurs dans la cat&eacute;gorie nationale (Baptiste CHATAIGNIER, J&eacute;r&eacute;my DUBOSC et Julien MORELLE).</p>

<p>L&#39;organisateur annonce l&#39;inscription de 800 patineurs parmi lesquels on pourra retrouver, outre les principaux clubs fran&ccedil;ais, &nbsp;des formations internationales prestigieuses (Etats Unis, Allemagne, Espagne, Portugal, Italie, Colombie, V&eacute;n&eacute;zuela...).</p>

<p>Les courses seront &agrave; suivre en direct sur <a href="http://www.3pistes.com" target="_blank">www.3pistes.com</a></p>
', Activity::IS_VALIDATED, new \DateTime('25-03-2013'));
        
    }

    protected function newArticle($category, $title, $user, $content, $valid, $date)
    {
        $article = new Article();
        $article->setCategory($category);
        $article->setTitle($title);
        $article->setContent($content);
        $article->setIsValid($valid);
        $article->setUser($user);
        $article->setDateSubmission($date);
        if ($valid === 0) {
            $article->setStatus(Article::DRAFTS);
            $article->setIsPublic(0);
        } else {
            $article->setStatus(Article::IMMEDIATE);
            $article->setIsPublic(1);
        }

        $this->manager->persist($article);
        $this->manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
