# sugarbirdFeeding
software engineering principles to simulate a sugarbird feeding on nectar of flowers during daytime

1. The observer pattern must be used to open and close the flowers and tell the sugarbird it is time to feed.
2. The sugarbird and the flowers will be observers of the sun’s on and off state.
3. The sun will stay on for 12 counts and off for 12 counts, ie. the flowers will be OPEN for 12 counts and the sugarbird can feed for 12 counts, the other 12 counts the sugarbird will sleep and the flowers will be closed. The sun should keep a global counter, so that we can measure the counts.
4. There should be 3 events : onDayStart, onDayEnd, onHourChange (change the flower that the bird feeds on). The sugarbird will feed on a different flower every hour, so the sugarbird can feed on 12 flowers in a day. The flowers do not need to do anything on the onHourChange event, the implemenation can be left blank.
5. There are 10 flowers and they can only be fed on 10 times by the sugarbird.
Once a flower cannot be fed on, the sugarbird will immediately try another flower.
NOTE: each flower = 10 visits but each visit must be at a different time
6. The sugarbird will always randomly pick which flower to feed on.
7. The flowers will remember their state from day to day.  So it will keep their feeding counts until the next day, so the flower will be empty after a few days of feeding.
8. The application will exit when there is no more nectar in any flower.
9. No timer needs to be used, the application can simply run and complete as fast as possible.
10. Print the results, as the application runs to file or console in the following fashion (count in parenthesis :
------------------------------------------------
DAY START (0)       HOUR CHANGE (0)
FLOWER-4 (9)       HOUR CHANGE (1)
FLOWER-8 (9)       HOUR CHANGE (2)
FLOWER-3 (9)       HOUR CHANGE (3)
FLOWER-4 (8)  <-- note, it randomly changed to the flower already visited.