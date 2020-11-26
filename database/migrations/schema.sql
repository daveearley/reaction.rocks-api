CREATE TABLE "accounts" (
  "id" SERIAL PRIMARY KEY,
  "first_name" varchar(55),
  "last_name" varchar(55),
  "parent_id" int null references accounts(id),
  "password" varchar(64) not null,
  "email" varchar(100) unique not null,
  "created_at" timestamp,
  "updated_at" timestamp,
  "deleted_at" timestamp
);

CREATE INDEX idx_accounts_parent_id ON accounts (parent_id);

CREATE TABLE "campaigns" (
  "id" SERIAL PRIMARY KEY,
  "public_id" varchar(32),
  "name" varchar(50),
  "account_id" int not null references accounts(id),
  "allowed_domains" varchar(255),
  "type" varchar(32),
  "heading" varchar(255),
  "sub_heading" varchar (255),
  "start_behaviour" varchar (32), /* on-click, start open, on-hover */
  "only_show_on_first_session" boolean,
  "tab_position" varchar(32),
  "tab_text_color" varchar(7),
  "tab_background_color" varchar(7),
  "tab_text" varchar (50),
  "positive_question" text,
  "negative_question" text,
  "neutral_question" text,
  "thank_you_message" text,
  "emojis" varchar(50),
  "emoji_titles" varchar (255),
  "show_stats" boolean,
  "stats_display_type" varchar (32), /* percent, number */
  "has_reactions" boolean default false not null,
  "button_background_color" null varchar(7),
  "button_text_color" null varchar(7),
  "theme_color" null varchar(7),
  "created_at" timestamp,
  "updated_at" timestamp,
  "deleted_at" timestamp
);

CREATE INDEX idx_campaigns_public_id ON campaigns (public_id);
CREATE INDEX idx_campaigns_account_id ON campaigns (account_id);

CREATE TABLE "reactions" (
  "id" SERIAL PRIMARY KEY,
  "score" int not null,
  "emoji" varchar (12) not null,
  "feedback_message" text,
  "client_identifier" varchar(45),
  "country_code" varchar(3),
  "city" varchar (45),
  "browser" varchar (45),
  "browser_version" varchar (32),
  "platform" varchar (45),
  "referer" varchar (355),
  "campaign_id" int not null references campaigns(id),
  "client_ip" varchar (16),
  "user_data" json,
  "created_at" timestamp,
  "updated_at" timestamp,
  "deleted_at" timestamp
  );

CREATE INDEX idx_reactions_client_id ON reactions (client_identifier);
CREATE INDEX idx_reactions_campaign_id ON reactions (campaign_id);
