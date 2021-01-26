# Tasks
Get motivated to do your tasks,

If you like me, you have a bunch of task you want too do. I wanted a way to complete those tasks and have an empty list at the end of the year. I believe if you don't set a manageable goal you won't achieve it.

For example; I want to lose 0.5 kg each month is better then, I want to lose 6kg this year. Otherwise the procrastinator in the person comes active and for you know it, it is December. 

The first goal as not adding one more project too my task list, so this is very quick and dirty. Maybe some time I will improve it. Just to clarify **this is a very work in progress project** !


## So what is this ? 
This is a POC, this project will count every task you created in Outlook and calculate how many task you have to complete this week. It will create a history of the number of task open each hour, day and week. This way you will see your own progress and get motivated too achieve your goal: Zero tasks at the end of the year.



![screenshot1](https://github.com/thijsbekke/tasks/blob/master/img/screenshot1.png)

![screenshot1](https://github.com/thijsbekke/tasks/blob/master/img/screenshot2.png)

## Installation

- Create a database and execute db.sql
- Create an app at https://apps.dev.microsoft.com
- Rename config.example.php to config.php and fill in your credentials. 
- Add a cronjob which polls cron.php every hour.
- Do a composer update
- When navigating with your browser everything _should_ work.
 
