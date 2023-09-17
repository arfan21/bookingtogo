package familydomain

import (
	"encoding/json"
	"time"

	"github.com/arfan21/bookingtogo/constant"
)

type Family struct {
	FLId       int       `json:"-"`
	FLName     string    `json:"nama"`
	FLRelation string    `json:"hubungan"`
	FLDOB      time.Time `json:"tanggal_lahir"`
	CstID      int       `json:"-"`
}

type FamilyResponse struct {
	FLId       int       `json:"-"`
	FLName     string    `json:"nama"`
	FLRelation string    `json:"hubungan"`
	FLDOB      time.Time `json:"tanggal_lahir"`
	CstID      int       `json:"-"`
}

func (family *FamilyResponse) MarshalJSON() ([]byte, error) {
	type Alias FamilyResponse
	return json.Marshal(&struct {
		Alias
		FLDOB string `json:"tanggal_lahir"`
	}{
		Alias: (Alias)(*family),
		FLDOB: family.FLDOB.Format(constant.DOBFormat),
	})
}

func (family *FamilyResponse) FromDB(data Family) {
	family.FLId = data.FLId
	family.FLName = data.FLName
	family.FLRelation = data.FLRelation
	family.FLDOB = data.FLDOB
	family.CstID = data.CstID
}
