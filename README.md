AHRQ Mirror Project
=====================


* [go_wayback.function.php](go_wayback.function.php) - Uses the wayback machine API to get the latest copy of a page
* [get_expert_commentary.php](get_expert_commentary.php) - mirrors expert commentary, into the expert_commentary directory
* [expert_commentary](/export_comnmentary) - A mirror of the expert commentary https://www.qualitymeasures.ahrq.gov/expert and https://www.guideline.gov/expert

### Guidelines

* [get_guidelines.php](get_guidelines.php) - A simple script that downloads all guidelines search results
* [extract_guideline_links.php](extract_guideline_links.php) - Once get_guidelines.php is run, use this to download from wayback, the latest version of guidelines. Create guideline_links.csv which shows what was gettable and how old it was.
* [guidelines_links.csv](guidelines_links.csv) - shows the guidelines and which timestamp that wayback machine got for them.
* [www.guideline.gov](www.guideline.gov) - contains the actual mirror 


### Measures Clearinghouse

* [get_measures.php](get_measures.php) - downloads measure clearinghouse search results
* [extract_measures_links.php](extract_measures_links.php) - extract the specific measures from search results and tries to download from wayback machine
* [measures_links.csv](measures_links.csv) - the status and timestamps for the measures clearninghouse mirror
* [www.qualitymeasures.ahrq.gov](www.qualitymeasures.ahrq.gov) - contains the measures clearningout mirror


### Measures inventory
* [get_measure_inventory.php](get_measure_inventory.php) - Creates the mirror. Uses url counter instead of search results.. 
* [measures_inventory](measures_inventory) - The mirror of the measures inventory page [https://www.qualitymeasures.ahrq.gov/hhs/index.aspx](https://www.qualitymeasures.ahrq.gov/hhs/index.aspx)


### Expert Commentary
There are three sections of commentary and synthesis that appear to be original articles hosted on these websites. The urls are: 

* https://guideline.gov/expert
* https://guideline.gov/syntheses/index
* https://www.qualitymeasures.ahrq.gov/expert

These are backed up by downloading the main page to the one_off_mirror directory and then parsing that html for links that 
match pattern in the all of the urls. 

* [get_expert_commentary.php](get_expert_commentary.php) - parses the already downloaded index pages, and then downloads each commentary in turn
* [expert_commentary](expert_commentary) - the directory where the expert commentary documents are stored


### manual backups

* [one_off_mirror](one_off_mirror) - things I thought were worth downloading that do not belong anywhere else
