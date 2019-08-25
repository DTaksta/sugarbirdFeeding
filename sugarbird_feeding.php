<?php

    abstract class AbstractObserver 
    {
        abstract function update(AbstractSubject $subject);
    }

    abstract class AbstractSubject
    {
        abstract function attach(AbstractObserver $observer);
        abstract function detach(AbstractObserver $observer);
        abstract function notify();
    }

    interface IEvent
    {
        function onDayStart($hour);

        function onDayEnd($hour);

        function onHourChange($hour);
    }

    class SunSubject extends AbstractSubject implements IEvent
    {
        private $observers = [];
        public $state;

        function __construct($state)
        {
            $this->state = $state;
        }

        function attach(AbstractObserver $observer)
        {
            array_push($this->observers, $observer);
        }

        function detach(AbstractObserver $observer)
        {
            foreach ($this->observers as $obKey => $obValue) {
                if ($obValue == $observer) {
                    unset($this->observers[$obKey]);
                }
            }
        }

        function notify()
        {
            /* notify all observers about any change in SunSubject */
            foreach ($this->observers as $obKey => $obValue) {
                $obValue->update($this);
            }
        }

        public function onDayStart($hour)
        {
            echo 'DAY START ('. $hour .')'.PHP_EOL;

            $this->state = true;

            $this->notify();
        }

        public function onDayEnd($hour)
        {
            echo 'DAY END ('. $hour .')'.PHP_EOL;

            $this->state = false;

            $this->notify();
        }

        public function onHourChange($hour)
        {
            echo 'HOUR CHANGE ('. $hour .')'.PHP_EOL;
        }
    }

    class SugarbirdObserver extends AbstractObserver 
    {
        public $sleepState;

        public function __construct()
        {

        }

        public function update(AbstractSubject $subject)
        {
            $this->sleepState = $subject->state;
        }

        public function feed($flower)
        {
            $flower->isFeedable = false;
            $flower->nectar--;

        }
    }

    class FlowerObserver extends AbstractObserver 
    {
        public $openState;
        public $isFeedable;
        public $nectar;

        public function __construct($openState, $isFeedable, $nectar)
        {
            $this->openState = $openState;
            $this->isFeedable = $isFeedable;
            $this->nectar = $nectar;
        }

        public function update(AbstractSubject $subject)
        {
            $this->openState = $subject->state;
            $this->isFeedable = $subject->state;
        }
    }


    $sunSubObj = new SunSubject(true);

    $sugarbirdObsObj = new SugarbirdObserver();

    $sunSubObj->attach($sugarbirdObsObj);

    $counter = 0;

    /* Generate 10 FlowerObserver object and subscribe to SunSubject */
    for ($i = 1; $i <= 10; $i++) {
        /* Assign intial state value of FlowerObserver object */
        $flowerObs[] = $obj = new FlowerObserver(true, true, 10);
        
        /* subscribe to SunSubject */
        $sunSubObj->attach($obj);
    }

    $hr = 0;

    /* Continue while loop untill all flowers are empty */
    do {
        if ($hr == 0) {
            $sunSubObj->onDayStart($hr);
            
        } elseif ($hr == 11 || $hr == 23) {
            $sunSubObj->onDayEnd($hr);
            
        } 
        
        $sunSubObj->onHourChange($hr);
        
        /* Check sun is on or off */
        
        if ($sunSubObj->state == true) {

            $flower = rand(0, 9);
            
            echo 'FLOWER-'. ($flower+1) .' ('. $flowerObs[$flower]->nectar .')'.PHP_EOL;
            
            /* Check flower alread has been fed today or not */
            if ( $flowerObs[$flower]->isFeedable ) {
                
                /* Check flower is empty or not. If not, feed the bird */
                if ($flowerObs[$flower]->nectar != 0) { 
                    $sugarbirdObsObj->feed($flowerObs[$flower]);
                } else {
                    //Is left blank as flowers do not have to implement anything on hour change.
                }
            }

        } else {
            echo 'SLEEP'.PHP_EOL;
        }        
        
        
        if ($hr < 23) {
            $hr++;
        } else {
            /* Reset hour counter */
            $hr = 0;
        }   

        $counter++;

        /* To prevent an infinity loop */
        if ($counter > 30000) {
            break;
        }
    } while ($flowerObs[$flower]->nectar != 0);

    echo '---------------------'.PHP_EOL;
    echo 'EXIT ('. $counter .')'.PHP_EOL;
        
?>