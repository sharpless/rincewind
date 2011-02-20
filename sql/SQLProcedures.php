<?php
$queryProcedures = <<<EOD
-- -----------------------------------------------------
-- procedure {$SPInsertOrUpdateUser}
-- -----------------------------------------------------
DROP procedure IF EXISTS `{$SPInsertOrUpdateUser}`;

CREATE PROCEDURE `{$SPInsertOrUpdateUser}` (
  IN aUserId INT,
  IN aUserLogin VARCHAR(20),
  IN aUserEmail VARCHAR(80),
  IN aUserName VARCHAR(80),
  IN aUserPassword CHAR(32)
)
BEGIN
  IF aUserId = 0 THEN
  BEGIN
    INSERT INTO {$tableUsers} (
      user_login,
      user_email,
      user_name,
      user_password,
      user_created_date
    ) VALUES (
      aUserLogin,
      aUserEmail,
      aUserName,
      MD5(aUserPassword),
      NOW()
    );
    SET aUserId = LAST_INSERT_ID();
    INSERT INTO {$tableGroupMember} (
      member_id,
      group_id
    ) VALUES (
      aUserId,
      2
    );
  END;
  ELSE
  BEGIN
    UPDATE {$tableUsers}
    SET
      user_login = aUserLogin,
      user_email = aUserEmail,
      user_name = aUserName,
      user_password = MD5(aUserPassword)
    WHERE
      user_id = aUserId;
  END;
  END IF;
  SELECT aUserId;
END;

-- -----------------------------------------------------
-- procedure {$SPInsertOrUpdatePost}
-- -----------------------------------------------------
DROP procedure IF EXISTS `{$SPInsertOrUpdatePost}`;

CREATE PROCEDURE `{$SPInsertOrUpdatePost}` (
  IN aPostId INT,
  IN aPostAuthor INT,
  IN aThreadId INT,
  IN aPostTopic VARCHAR(80),
  IN aPostContent TEXT,
  IN aIsDraft BOOL,
  IN aPostModifiedReason VARCHAR(80)
)
BEGIN
  IF aThreadId = 0 THEN
  BEGIN
    INSERT INTO {$tableThreads} (thread_topic) VALUES (aPostTopic);
    SET aThreadId = LAST_INSERT_ID();
  END;
  END IF;
  IF aPostId = 0 THEN
  BEGIN
    INSERT INTO {$tableThreadPosts} (post_author_id, post_thread_id, post_topic, post_content, post_created_date, post_is_draft)
      VALUES (aPostAuthor, aThreadId, aPostTopic, aPostContent, NOW(), aIsDraft);
    SET aPostId = LAST_INSERT_ID();
  END;
  ELSE
  BEGIN
    UPDATE {$tableThreadPosts} SET
    post_topic = aPostTopic,
    post_content = aPostContent,
    post_modified_reason = aPostModifiedReason,
    post_modified_date = NOW(),
    post_is_draft = aIsDraft
    WHERE post_id = aPostId;
  END;
  END IF;
  SELECT aPostId, aThreadId;
END;
-- -----------------------------------------------------
-- procedure {$SPDisplayThread}
-- -----------------------------------------------------
DROP procedure IF EXISTS `{$SPDisplayThread}`;

CREATE PROCEDURE `{$SPDisplayThread}` (
  IN aThreadId INT
)
BEGIN
  SELECT post_id,
    post_topic,
    post_content,
    post_created_date,
    post_modified_reason,
    post_modified_date,
    user_name,
    user_email
  FROM {$tableThreadPosts}
    INNER JOIN {$tableUsers}
    ON post_author_id = user_id
  WHERE post_thread_id = aThreadId AND post_is_draft = 0 ORDER BY post_created_date ASC;
END;
-- -----------------------------------------------------
-- function FCheckAuthorOrAdmin
-- -----------------------------------------------------
DROP function IF EXISTS `{$FCheckAuthorOrAdmin}`;

CREATE FUNCTION {$FCheckAuthorOrAdmin} (
  aPostId INT,
  aUserId INT
)
RETURNS BOOLEAN
BEGIN
  DECLARE isAdmin INT;
  DECLARE isOwner INT;
  SELECT post_author_id INTO isOwner FROM {$tableThreadPosts} WHERE post_id = aPostId AND post_author_id = aUserId;
  SELECT member_id INTO isAdmin FROM {$tableGroupMember} AS GM JOIN {$tableGroups} AS G ON GM.group_id = G.group_id WHERE member_id = aUserId AND group_name = 'adm';
  RETURN (isAdmin OR isOwner);
END;
-- -----------------------------------------------------
-- procedure {$SPDisplayThreadsList}
-- -----------------------------------------------------
DROP procedure IF EXISTS `{$SPDisplayThreadsList}`;

CREATE PROCEDURE `{$SPDisplayThreadsList}` ()
BEGIN
  SELECT thread_id,
    thread_topic,
    user_name,
    (SELECT MAX(COALESCE(post_modified_date, post_created_date))) AS latest
  FROM {$tableThreads}
  INNER JOIN {$tableUsers}
    ON thread_author_id = user_id
  LEFT JOIN {$tableThreadPosts}
    ON thread_id = post_thread_id
  GROUP BY thread_id;
END;

-- -----------------------------------------------------
-- procedure SPDisplayPost
-- -----------------------------------------------------
DROP procedure IF EXISTS {$SPDisplayThreadPost};

CREATE PROCEDURE {$SPDisplayThreadPost} (
  IN aPostId INT
)
BEGIN
  SELECT post_topic,
    post_content,
    post_created_date,
    post_modified_reason,
    post_modified_date,
    user_name,
    post_thread_id
  FROM {$tableThreadPosts}
    INNER JOIN {$tableUsers}
    ON post_author_id = user_id
  WHERE post_id = aPostId;
END;

-- -----------------------------------------------------
-- procedure SPDisplayPostsList
-- -----------------------------------------------------
DROP procedure IF EXISTS `{$SPDisplayPostsList}`;

CREATE PROCEDURE `{$SPDisplayPostsList}` ()
BEGIN
  SELECT post_id,
    post_topic,
    post_thread_id
  FROM {$tableThreadPosts}
  WHERE post_is_draft = 0
  ORDER BY post_id DESC
  LIMIT 5;
END;

-- -----------------------------------------------------
-- procedure SPDisplayDrafts
-- -----------------------------------------------------
DROP procedure IF EXISTS `{$SPDisplayDrafts}`;

CREATE PROCEDURE `{$SPDisplayDrafts}` (
  IN aUserId INT
)
BEGIN
  SELECT post_id,
    post_topic,
    post_thread_id
  FROM {$tableThreadPosts}
  WHERE post_is_draft = 1
    AND (SELECT {$FCheckAuthorOrAdmin}(post_id, aUserId));
END;

EOD;
?>
