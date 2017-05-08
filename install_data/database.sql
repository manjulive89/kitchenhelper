-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 08. Mai 2017 um 18:28
-- Server-Version: 10.0.22-MariaDB
-- PHP-Version: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `kitchenhelper`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `[prefix]dietaries`
--

CREATE TABLE `[prefix]dietaries` (
  `id` int(11) NOT NULL,
  `description` varchar(140) NOT NULL DEFAULT 'None',
  `name` varchar(64) NOT NULL,
  `danger` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `[prefix]groups`
--

CREATE TABLE `[prefix]groups` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `ticks` text NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Tabellenstruktur für Tabelle `[prefix]groupsdiets`
--

CREATE TABLE `[prefix]groupsdiets` (
  `id` int(11) NOT NULL,
  `gID` int(11) NOT NULL,
  `dID` int(11) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `[prefix]meal`
--

CREATE TABLE `[prefix]meal` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `points` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `[prefix]mealplanner`
--

CREATE TABLE `[prefix]mealplanner` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `active` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `activationtime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Tabellenstruktur für Tabelle `[prefix]meals`
--

CREATE TABLE `[prefix]meals` (
  `id` int(11) NOT NULL,
  `mpID` int(11) NOT NULL,
  `mID` int(11) NOT NULL,
  `mtID` int(11) NOT NULL,
  `repeats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Tabellenstruktur für Tabelle `[prefix]mealtimes`
--

CREATE TABLE `[prefix]mealtimes` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `start` int(11) NOT NULL,
  `finish` int(11) NOT NULL,
  `packable` int(11) NOT NULL,
  `tax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Tabellenstruktur für Tabelle `[prefix]messages`
--

CREATE TABLE `[prefix]messages` (
  `id` int(11) NOT NULL,
  `sender` int(11) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `date` int(11) NOT NULL,
  `seen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `[prefix]notifications`
--

CREATE TABLE `[prefix]notifications` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `fixed` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(128) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `[prefix]settings`
--

CREATE TABLE `[prefix]settings` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `[prefix]settings`
--

INSERT INTO `[prefix]settings` (`id`, `name`, `content`) VALUES
(1, 'base_url', '[baseurl]'),
(2, 'pagename', '[pagename]'),
(3, 'helptexts', '[{\"name\":\"Sign Off Sheet\",\"data\":{\"helptext_nbofpeople\":{\"name\":\"Number of People who eat\",\"content\":\"Number of people eating:\"},\"helptext_nbrofpeopeeating\":{\"name\":\"Nr. of people includes\",\"content\":\" In the above shown numbers are the tax benift numbers included.\"},\"helptext_diets\":{\"name\":\"Diets help text\",\"content\":\"For more information click on the diet. If a dietary will be shown with ared background it means that this dietary is dangerous\"},\"helptext_nodiets\":{\"name\":\"No Diets note\",\"content\":\"No Dietaries\"},\"helptext_nopart\":{\"name\":\"No Participants\",\"content\":\"No data\"},\"helptext_nboftb\":{\"name\":\"FTB Name\",\"content\":\"Numbers of participants with tax Benifts\"},\"helptext_howpeopleweek\":{\"name\":\"How many People per week\",\"content\":\"How many participants ate during the week\"},\"helptext_fbtweek\":{\"name\":\"How many FBT per week\",\"content\":\"How many participants ate during the week and had tax benefits\"},\"helptext_tickinfo\":{\"name\":\"Tick Explenation\",\"content\":\"If the tick is green (<span class=\'glyphicon glyphicon-ok text-success\'><\\/span>) then its a Tax Beneift\"},\"helptext_weekovervoewbydays\":{\"name\":\"How many people this week\",\"content\":\"For how many people ate this week\"},\"helptext_signoffsheet_info\":{\"name\":\"Frontend Signoffsheet explenations\",\"content\":\"Please make sure that you tick always for every Mealtime which you want to vist. Make sure as well that you tick with the right type. (Press the Blue information button for more information).<br> You cannot find your name because you are a Casual or a Guest? No problem add your name to the list. If you are a new Employee please talk to the right person...\"},\"helptext_tick_explain\":{\"name\":\"Tick dialog text\",\"content\":\"Please tick right\"},\"helptext_sheet_tick_explenation\":{\"name\":\"Tick information button\",\"content\":\"Tick types\"},\"helptext_btndefault_sheet\":{\"name\":\"Untick\\/Not ticked\",\"content\":\"You are not ticked or you wish to untick\"},\"helptext_btnnormal_sheet\":{\"name\":\"Normal tick\",\"content\":\"Normal Tick\"},\"helptext_btnftb_sheet\":{\"name\":\"tax tick\",\"content\":\"Tax benefids tick\"},\"helptext_btnpacked_sheet\":{\"name\":\"Packed tick\",\"content\":\"You want to have your meal take away from the staff fridge\"}}},{\"name\":\"Mealplanner\",\"data\":{\"helptext_ovallplansak\":{\"name\":\"Overview of all Aktive Plans\",\"content\":\"Overview over all activeated mealplans:\"},\"helptext_ovallplansinak\":{\"name\":\"Overview of all Inactive Plans\",\"content\":\"Overview over all inactiveated mealplans:\"},\"helptext_mpgeneral\":{\"name\":\"General Help\",\"content\":\"If you wish to edit a Mealplanner you have to click on the pencil and then it will appear on the right side. If you wish to create a new Mealplan you only have to fill out the right side forms and click on save. If you wish to edit or add a new Mealtime please navigate through the Tabbar and clickn on the name Mealtimes. Its the same for meals.\"},\"helptext_draganddropmp\":{\"name\":\"Helpext drang and drop\",\"content\":\"To change the order of activation you can drag and drop the list above. <i>Please note if you change the order to the first Element of the list you will activate this list for the current Week!<br> <strong>Organge Button<\\/strong><br> The orange button with the star in it allows you to activate or inactive a mealplan complete. Inactive in this content means that they will be not selected to be shown.<\\/i>\"},\"helptext_repeat\":{\"name\":\"What is the meaning of Repeat:\",\"content\":\" Repeat: This option means that this meal will repeat itself on every day where no meal can be find. For example: You only have set a meal on Sunday adn ticked repeat. As a result of this the planner will show everyday whitout a meal this meal.\"},\"helptext_emptymealtime\":{\"name\":\"No Mealtimes\",\"content\":\"- Please add some mealtimes -\"},\"helptext_nompinactive\":{\"name\":\"No Mealplans Inactive:\",\"content\":\"- No mealplan is inactive -\"},\"helptext_nompactive\":{\"name\":\"No Mealplans active:\",\"content\":\"- No mealplan is active -\"},\"helptext_ovmealtimes\":{\"name\":\"Overview of mealtimes:\",\"content\":\"Overview over all mealstimes:\"},\"helptext_delinfomt\":{\"name\":\"Delete warning for mealtimes:\",\"content\":\"If you delete a mealtime you will delete at the sametime all database entires where someone ate here!\"},\"helptext_msoption\":{\"name\":\"What does Packable\\/FTB means:\",\"content\":\"Packable: This feture means that people can pack their own lunch. If its ticked people can choose between 3 options when they tick: Normal, FBT and Packed<br>FTB: [Dummy text]\"},\"helptext_use24h\":{\"name\":\"Use 24h System\",\"content\":\"Please use 24h System!\"},\"helptext_mpname2l\":{\"name\":\"Mealplan name error\",\"content\":\"A Mealplanname must be longer then 2 letters!\"},\"helptext_mpnomt\":{\"name\":\"Mealplan no mealtimes\",\"content\":\"A Mealplanname must have at least 1 mealtime!\"},\"helptext_mtletters\":{\"name\":\"Letter in the mealtime name\",\"content\":\"Every Mealtime need a name with more then 2 letters and a start and finishing time\"},\"helptext_mletters\":{\"name\":\"Letter in the meal name\",\"content\":\"Every Meal must have at least 3 letters\"},\"helptext_add2mt\":{\"name\":\"Add 2 mealtimes\",\"content\":\"You cannot add two times the same Mealtime!\"},\"helptext_star\":{\"name\":\"What means a star\",\"content\":\" stands for how the people like the dish. The value is out of 10\"},\"helptext_mpdelmsg\":{\"name\":\"Delete mealplan\",\"content\":\"Do you wish to delete this mealplanner?\"},\"helptext_mtdelmsg\":{\"name\":\"Delete mealtime\",\"content\":\"Do you wish to delete this mealtime? <p class=\'text-danger\'>This will have influances on the statistics!<\\/p>\"},\"helptext_mdelmsg\":{\"name\":\"Delete meal\",\"content\":\"Do you wish to remove this meal?\"},\"helptext_clickonmealtoremove\":{\"name\":\"Click on Meal to Remove adn drag and drope\",\"content\":\"To remove a meal please click on it. If you wish to change the order you can drang and drop them up and down.\"},\"helptext_clickonmealtoadd\":{\"name\":\"Click on Meal to add\",\"content\":\"Choose meal from dropdown to add to list\"},\"helptext_mealplannerfrontent_info\":{\"name\":\"Frontend Mealplanner help text\",\"content\":\"If you like a dish you can show it ...\"}}},{\"name\":\"Messages Box\",\"data\":{\"helptext_nomesageselc\":{\"name\":\"No message selected\",\"content\":\"Please choose a message to read\"},\"helptext_delmsg\":{\"name\":\"Delete\",\"content\":\"Do you want to delete this message?\"},\"helptext_msg_del\":{\"name\":\"Message deleted\",\"content\":\"The message was succesfully deleted!\"},\"helptext_messagebox_info\":{\"name\":\"Frontend Messages Box helptext\",\"content\":\"All fields are required. If you are not an Employee no worries you can add your private E-Mail adress\"}}},{\"name\":\"Notifications\",\"data\":{\"helptext_fixed\":{\"name\":\"fixed:\",\"content\":\"If you tick fixed this notification will be always on top.\"},\"helptext_important\":{\"name\":\"Important:\",\"content\":\"If you tick important this notification will be highlighted.\"},\"helptext_del\":{\"name\":\"Delete\",\"content\":\"Do you want to remove this notification?\"}}},{\"name\":\"User Management\",\"data\":{\"helptext_listsortgroup\":{\"name\":\"List sorted by Group\",\"content\":\"List of all Users sorted by Group:\"},\"helptext_removed\":{\"name\":\"Removed List header\",\"content\":\"List of all Deleted Users sorted by Group:\"},\"helptext_usersaved\":{\"name\":\"User saved helptext\",\"content\":\"User was saved\"},\"helptext_udel\":{\"name\":\"Delete user\",\"content\":\"Do you really wish to remove this user?\"},\"helptext_gdel\":{\"name\":\"Delete group\",\"content\":\"Do you really wish to remove this group?\"},\"helptext_dddgel\":{\"name\":\"Delete Group\",\"content\":\"Do you really want to remove this group? <p class=\'text-danger\'><span class=\'glyphicon glyphicon-warning-sign\'><\\/span> Be aware of that if you  delete this group you will change the Group of all users this group to Default. This might has impact on your statistics<\\/p>\"},\"helptext_group_2l\":{\"name\":\"Group name letter error\",\"content\":\"Group name should have more the 2 or exact 2 letters\"},\"helptext_ddel\":{\"name\":\"Delete diet\",\"content\":\"Do you really wish to remove this diet?\"},\"helptext_role\":{\"name\":\"Role of user:\",\"content\":\"If not set all user get user state automaticly\"},\"helptext_password\":{\"name\":\"Password\",\"content\":\"A Admin needs a password and the password must be longer then 4 letters and it must be the same\"},\"helptext_usererroremail\":{\"name\":\"Email error\",\"content\":\"Something went wrong: Please make sure that noone else uses the same E-Mail adress...\"},\"helptext_newusererror\":{\"name\":\"New User data error\",\"content\":\"Every user needs a email adress and a name or surname\"},\"helptext_newuser_group\":{\"name\":\"Group Error\",\"content\":\"Every user needs a Group!\"},\"helptext_what_means_lifeth\":{\"name\":\"What is the meaning of  Life threatened\",\"content\":\"Life threatened\"},\"helptext_why_red\":{\"name\":\"Why is the diet background color red?\",\"content\":\"If the background color of a diet is read, it means its dangerours\"}}},{\"name\":\"E-Mails\",\"data\":{\"password_changed_subject\":{\"name\":\"E-Mail subject if the admin or manager is changing the password\",\"content\":\"[kitchenhelper_name]: Your password was changed\"},\"password_changed_msg\":{\"name\":\"E-Mail text if the admin or manager is changing the password\",\"content\":\"Hello [name] [surname] the admin changed your password. Your new password is now:[password]\"},\"welcome_msg\":{\"name\":\"E-Mail a user gets after a account was created\",\"content\":\"Welcome as a user of [kitchenhelper_name]. You can now use the Dashboard!\"},\"welcome_subject\":{\"name\":\"E-Mail subject a user gets after a account was created\",\"content\":\"[kitchenhelper_name]: Welcome new user!\"}}}]'),
(4, 'pagetitle', 'test'),
(5, 'password', '$2y$10$.q3vt4ATbZBwXz7LrpeqWOGvTBbhwlJdDmMBYBAmpgq9RmLEtndm6'),
(6, 'lastdbreset', ''),
(7, 'EMailAddress', 'domain.tld'),
(8, 'sendMail', '1'),
(9, 'password_changed_subject', '[kitchenhelper_name]: Your password was changed'),
(10, 'password_changed_msg', 'Hello [name] [surname] the admin changed your password. Your new password is now:[password]'),
(11, 'welcome_msg', 'Welcome as a user of [kitchenhelper_name]. You can now use the Dashboard!'),
(12, 'welcome_subject', '[kitchenhelper_name]: Welcome new user!');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `[prefix]ticked`
--

CREATE TABLE `[prefix]ticked` (
  `id` int(11) NOT NULL,
  `mtID` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `[prefix]user`
--

CREATE TABLE `[prefix]user` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT 'Max',
  `surname` varchar(64) DEFAULT 'Mustermann',
  `email` text NOT NULL,
  `group` int(11) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0',
  `password` text NOT NULL,
  `removed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `[prefix]userdietaries`
--

CREATE TABLE `[prefix]userdietaries` (
  `id` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `dID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `[prefix]usergroups`
--

CREATE TABLE `[prefix]usergroups` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `[prefix]usergroups`
--

INSERT INTO `[prefix]usergroups` (`id`, `name`) VALUES
(1, 'Dummy');
--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `[prefix]dietaries`
--
ALTER TABLE `[prefix]dietaries`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `[prefix]groups`
--
ALTER TABLE `[prefix]groups`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `[prefix]groupsdiets`
--
ALTER TABLE `[prefix]groupsdiets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gID` (`gID`),
  ADD KEY `dID` (`dID`);

--
-- Indizes für die Tabelle `[prefix]meal`
--
ALTER TABLE `[prefix]meal`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `[prefix]mealplanner`
--
ALTER TABLE `[prefix]mealplanner`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `[prefix]meals`
--
ALTER TABLE `[prefix]meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mpID` (`mpID`),
  ADD KEY `mID` (`mID`),
  ADD KEY `mtID` (`mtID`);

--
-- Indizes für die Tabelle `[prefix]mealtimes`
--
ALTER TABLE `[prefix]mealtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `[prefix]messages`
--
ALTER TABLE `[prefix]messages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `[prefix]notifications`
--
ALTER TABLE `[prefix]notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `[prefix]settings`
--
ALTER TABLE `[prefix]settings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `[prefix]ticked`
--
ALTER TABLE `[prefix]ticked`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mtID` (`mtID`);

--
-- Indizes für die Tabelle `[prefix]user`
--
ALTER TABLE `[prefix]user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupID` (`group`);

--
-- Indizes für die Tabelle `[prefix]userdietaries`
--
ALTER TABLE `[prefix]userdietaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uID` (`uID`),
  ADD KEY `dID` (`dID`);

--
-- Indizes für die Tabelle `[prefix]usergroups`
--
ALTER TABLE `[prefix]usergroups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `[prefix]dietaries`
--
ALTER TABLE `[prefix]dietaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]groups`
--
ALTER TABLE `[prefix]groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `[prefix]groupsdiets`
--
ALTER TABLE `[prefix]groupsdiets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]meal`
--
ALTER TABLE `[prefix]meal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]mealplanner`
--
ALTER TABLE `[prefix]mealplanner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]meals`
--
ALTER TABLE `[prefix]meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]mealtimes`
--
ALTER TABLE `[prefix]mealtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]messages`
--
ALTER TABLE `[prefix]messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `[prefix]notifications`
--
ALTER TABLE `[prefix]notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `[prefix]settings`
--
ALTER TABLE `[prefix]settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT für Tabelle `[prefix]ticked`
--
ALTER TABLE `[prefix]ticked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]user`
--
ALTER TABLE `[prefix]user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]userdietaries`
--
ALTER TABLE `[prefix]userdietaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT für Tabelle `[prefix]usergroups`
--
ALTER TABLE `[prefix]usergroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `[prefix]groupsdiets`
--
ALTER TABLE `[prefix]groupsdiets`
  ADD CONSTRAINT `[prefix]groupsdiets_ibfk_1` FOREIGN KEY (`gID`) REFERENCES `[prefix]groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `[prefix]groupsdiets_ibfk_2` FOREIGN KEY (`dID`) REFERENCES `[prefix]dietaries` (`id`);

--
-- Constraints der Tabelle `[prefix]meals`
--
ALTER TABLE `[prefix]meals`
  ADD CONSTRAINT `[prefix]meals_ibfk_1` FOREIGN KEY (`mpID`) REFERENCES `[prefix]mealplanner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `[prefix]meals_ibfk_2` FOREIGN KEY (`mID`) REFERENCES `[prefix]meal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `[prefix]meals_ibfk_3` FOREIGN KEY (`mtID`) REFERENCES `[prefix]mealtimes` (`id`);

--
-- Constraints der Tabelle `[prefix]ticked`
--
ALTER TABLE `[prefix]ticked`
  ADD CONSTRAINT `[prefix]ticked_ibfk_1` FOREIGN KEY (`mtID`) REFERENCES `[prefix]mealtimes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `[prefix]user`
--
ALTER TABLE `[prefix]user`
  ADD CONSTRAINT `[prefix]user_ibfk_1` FOREIGN KEY (`group`) REFERENCES `[prefix]usergroups` (`id`);

--
-- Constraints der Tabelle `[prefix]userdietaries`
--
ALTER TABLE `[prefix]userdietaries`
  ADD CONSTRAINT `[prefix]userdietaries_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `[prefix]user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `[prefix]userdietaries_ibfk_2` FOREIGN KEY (`dID`) REFERENCES `[prefix]dietaries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
